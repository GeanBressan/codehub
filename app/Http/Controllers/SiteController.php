<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;


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
}
