<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStore;
use App\Http\Requests\PostUpdate;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    public function index($slug)
    {
        $post = Post::where('slug', $slug)
            ->with(['category', 'tags', 'user', 'likedByUsers'])
            ->firstOrFail();
        
        if ($post->status !== 'published' && $post->user_id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Post não encontrado ou não publicado.');
        }

        $tagIds = $post->tags->pluck('id');
        $categoryId = $post->category_id;
        $postId = $post->id;

        $recommendedPosts = Post::where('status', 'published')
            ->where('post_at', '<=', now())
            ->where('id', '!=', $postId)
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($tagIds->isNotEmpty(), function ($query) use ($tagIds) {
                $query->withCount([
                    'tags as common_tags_count' => function ($query) use ($tagIds) {
                        $query->whereIn('tags.id', $tagIds);
                    }
                ])->orderByDesc('common_tags_count');
            })
            ->with(['category', 'tags', 'user', 'likedByUsers'])
            ->limit(5)
            ->get();

        // fallback se não encontrar nada
        if ($recommendedPosts->isEmpty()) {
            $recommendedPosts = Post::where('status', 'published')
                ->where('post_at', '<=', now())
                ->where('id', '!=', $postId)
                ->when($tagIds->isNotEmpty(), function ($query) use ($tagIds) {
                    $query->whereHas('tags', function ($q) use ($tagIds) {
                        $q->whereIn('tags.id', $tagIds);
                    });
                }, function ($query) {
                    $query->inRandomOrder();
                })
                ->with(['category', 'tags', 'user'])
                ->limit(5)
                ->get();
        }

        // fallback final se ainda estiver vazio
        if ($recommendedPosts->isEmpty()) {
            $recommendedPosts = Post::where('status', 'published')
                ->where('post_at', '<=', now())
                ->where('id', '!=', $postId)
                ->inRandomOrder()
                ->with(['category', 'tags', 'user'])
                ->limit(5)
                ->get();
        }

        $popularPosts = Post::where('status', 'published')
            ->where('post_at', '<=', now())
            ->with(['category', 'tags', 'user', 'likedByUsers'])
            ->withCount('likedByUsers as likes')
            ->orderBy('likes', 'desc')
            ->limit(5)
            ->get();

        if (Auth::check()) {
            $user = Auth::user();
            
            if (session()->has('last_post_viewed_by_' . $user->id)) {
                $lastPostViewed = session('last_post_viewed_by_' . $user->id);
            } else {
                $lastPostViewed = [];
            }

            if (!in_array($post->id, $lastPostViewed)) {
                $lastPostViewed[] = $post->id;
                session(['last_post_viewed_by_' . $user->id => $lastPostViewed]);
                $post->increment('views', 1);
                $post->save();
            }
        }

        return view('post.index', compact('post', 'recommendedPosts', 'popularPosts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        
        return view('post.create', compact('categories', 'tags'));
    }

    public function store(PostStore $request)
    {
        $request->validated();

        $post = new Post();
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->slug = Str::slug($request->input('title'), '-');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');
        $post->user_id = Auth::id();
        $post->status = $request->input('status');
        $post->post_at = now();
        $post->views = 0;

        if ($request->hasFile('cover_path')) {
            $fileName = Str::slug($request->input('title'), '-') . '-' . time() . '.' . $request->file('cover_path')->getClientOriginalExtension();
            $request->file('cover_path')->move(public_path('storage/uploads/posts'), $fileName);
            $post->cover_path = 'uploads/posts/' . $fileName;
        }

        $post->save();

        if ($request->has('tags')) {
            foreach ($request->input('tags') as $tagName) {
                $tag = Tag::where('name', $tagName)->first();
                if (!$tag) {
                    $tag = new Tag();
                    $tag->name = $tagName;
                    $tag->slug = Str::slug($tagName, '-');
                    $tag->save();
                }
                $post->tags()->attach($tag->id);
            }
        }

        return redirect()->route('post.show', $post->slug)->with('success', 'Post criado com sucesso!');
    }

    public function edit($id)
    {
        $user = Auth::user();

        $post = Post::findOrFail($id);
        $this->authorize('update', $post);

        $categories = Category::all();
        $tags = Tag::all();

        return view('post.edit', compact('post', 'categories', 'tags'));
    }

    public function update(PostUpdate $request, $id)
    {
        $user = Auth::user();

        $post = Post::findOrFail($id);

        $this->authorize('update', $post);

        $request->validated();

        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->slug = Str::slug($request->input('title'), '-');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');
        $post->status = $request->input('status');
        $post->tags()->detach();

        if ($request->hasFile('cover_path')) {
            if ($post->cover_path) {
                $filePath = public_path($post->cover_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $fileName = Str::slug($request->input('title'), '-') . '-' . time() . '.' . $request->file('cover_path')->getClientOriginalExtension();
            $request->file('cover_path')->move(public_path('storage/uploads/posts'), $fileName);
            $post->cover_path = 'uploads/posts/' . $fileName;
        }

        $post->save();

        if ($request->has('tags')) {
            foreach ($request->input('tags') as $tagName) {
                $tag = Tag::where('name', $tagName)->first();
                if (!$tag) {
                    $tag = new Tag();
                    $tag->name = $tagName;
                    $tag->slug = Str::slug($tagName, '-');
                    $tag->save();
                }
                $post->tags()->attach($tag->id);
            }
        }

        return redirect()->route('post.show', $post->slug)->with('success', 'Post atualizado com sucesso!');
    }

    public function destroyImage($id)
    {
        $user = Auth::user();

        $post = Post::findOrFail($id);

        $this->authorize('update', $post);

        $filePath = public_path($post->cover_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $post->cover_path = null;
        $post->save();

        return redirect()->back()->with('success', 'Imagem excluída com sucesso!');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $post = Post::findOrFail($id);

        $this->authorize('delete', $post);
        
        if ($post->status === 'published') {
            return redirect()->route('post.edit', $post->id)->with('error', 'Você não pode excluir um post publicado.');
        }

        if ($post->cover_path) {
            $filePath = public_path($post->cover_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('profile.index')->with('success', 'Post excluído com sucesso!');
    }
}
