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
        $categories = Category::has('posts')->inRandomOrder()->limit(10)->get();

        $tags = Tag::inRandomOrder()->limit(20)->get();

        $posts = Post::where('status', 'published')
            ->where('post_at', '<=', now())
            ->with(['category'])
            ->orderBy('post_at', 'desc')
            ->paginate(8);

        return view('index', compact('categories', 'tags', 'posts'));
    }

    public function show(Request $request)
    {
        $categories = Category::has('posts')->inRandomOrder()->limit(10)->get();

        $tags = Tag::inRandomOrder()->limit(20)->get();

        $post = Post::where('slug', $request->route('post'))
            ->with(['category'])
            ->firstOrFail();

        $converter = new CommonMarkConverter();
        $post->content = $converter->convertToHtml($post->content);
        $post->content = str_replace('<p>', '<p class="text-gray-700 mb-4">', $post->content);
        $post->content = str_replace('<h3>', '<h3 class="text-2xl font-semibold text-gray-800 mt-6 mb-2">', $post->content);
        
        return view('post-view', compact('categories', 'tags', 'post'));
    }
}
