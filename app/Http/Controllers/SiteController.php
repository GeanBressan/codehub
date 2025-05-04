<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\CommonMarkConverter;
use App\Models\User;

class SiteController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $categories = Category::whereHas('posts', function ($query) {
            $query->where('post_at', '<=', now());
        })->inRandomOrder()->limit(10)->get();

        $tags = Tag::whereHas('posts', function ($query) {
            $query->where('post_at', '<=', now());
        })->inRandomOrder()->limit(20)->get();

        $posts = Post::where('status', 'published')
            ->where('post_at', '<=', now())
            ->with(['category', 'tags', 'user', 'likedByUsers'])
            ->orderBy('post_at', 'desc')
            ->paginate(8);

        $popularPosts = Post::where('status', 'published')
            ->where('post_at', '<=', now())
            ->with(['category', 'tags', 'user', 'likedByUsers'])
            ->withCount('likedByUsers as likes')
            ->orderBy('likes', 'desc')
            ->limit(5)
            ->get();

        $popularAuthors = User::withCount('followers')
            ->whereHas('followers')
            ->orderBy('followers_count', 'desc')
            ->limit(5)
            ->get();

        return view('index', compact('categories', 'tags', 'posts', 'user', 'popularPosts', 'popularAuthors'))->with('success', 'teste');
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
            ->with(['category', 'tags', 'user'])
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
            ->with(['category', 'tags', 'user'])
            ->orderBy('post_at', 'desc')
            ->paginate(8);

        return view('tag', compact('categories', 'tags', 'posts', 'tag'));
    }
}
