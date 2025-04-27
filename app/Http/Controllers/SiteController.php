<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use League\CommonMark\CommonMarkConverter;

class SiteController extends Controller
{
    public function index()
    {
        $categories = Category::whereHas('posts', function ($query) {
            $query->where('post_at', '<=', now());
        })->inRandomOrder()->limit(10)->get();

        $tags = Tag::whereHas('posts', function ($query) {
            $query->where('post_at', '<=', now());
        })->inRandomOrder()->limit(20)->get();

        $posts = Post::where('status', 'published')
            ->where('post_at', '<=', now())
            ->with(['category'])
            ->orderBy('post_at', 'desc')
            ->paginate(8);

        return view('index', compact('categories', 'tags', 'posts'));
    }

    public function show(Request $request, $slug)
    {
        $categories = Category::whereHas('posts', function ($query) {
            $query->where('post_at', '<=', now());
        })->inRandomOrder()->limit(10)->get();

        $tags = Tag::whereHas('posts', function ($query) {
            $query->where('post_at', '<=', now());
        })->inRandomOrder()->limit(20)->get();

        $post = Post::where('slug', $slug)
            ->with(['category', 'tags'])
            ->firstOrFail();

        $converter = new CommonMarkConverter();
        $post->content = $converter->convertToHtml($post->content);
        $post->content = str_replace('<p>', '<p class="text-gray-700 mb-4">', $post->content);
        $post->content = str_replace('<h3>', '<h3 class="text-2xl font-semibold text-gray-800 mt-6 mb-2">', $post->content);
        
        return view('post-view', compact('categories', 'tags', 'post'));
    }

    public function category($slug)
    {
        $categories = Category::whereHas('posts', function ($query) {
            $query->where('post_at', '<=', now());
        })->inRandomOrder()->limit(10)->get();

        $tags = Tag::whereHas('posts', function ($query) {
            $query->where('post_at', '<=', now());
        })->inRandomOrder()->limit(20)->get();

        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::where('status', 'published')
            ->where('post_at', '<=', now())
            ->where('category_id', $category->id)
            ->with(['category', 'tags'])
            ->orderBy('post_at', 'desc')
            ->paginate(8);

        return view('category', compact('categories', 'tags', 'posts', 'category'));
    }

    public function tag(Request $request, $slug)
    {
        $categories = Category::whereHas('posts', function ($query) {
            $query->where('post_at', '<=', now());
        })->inRandomOrder()->limit(10)->get();

        $tags = Tag::whereHas('posts', function ($query) {
            $query->where('post_at', '<=', now());
        })->inRandomOrder()->limit(20)->get();

        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = Post::where('status', 'published')
            ->where('post_at', '<=', now())
            ->whereHas('tags', function ($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->with(['category'])
            ->orderBy('post_at', 'desc')
            ->paginate(8);

        return view('tag', compact('categories', 'tags', 'posts', 'tag'));
    }
}
