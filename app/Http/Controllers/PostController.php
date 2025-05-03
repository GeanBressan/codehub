<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index($slug)
    {
        $post = Post::where('slug', $slug)
            ->with(['category', 'tags', 'user'])
            ->firstOrFail();
        
        if ($post->status !== 'published' && $post->user_id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Post não encontrado ou não publicado.');
        }

        $converter = new CommonMarkConverter();
        $post->content = $converter->convertToHtml($post->content);
        $post->content = str_replace('<p>', '<p class="text-gray-700 mb-4">', $post->content);
        $post->content = str_replace('<h3>', '<h3 class="text-2xl font-semibold text-gray-800 mt-6 mb-2">', $post->content);

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
            ->with(['category', 'tags', 'user'])
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

        $mostViewedPosts = Post::where('status', 'published')
            ->where('post_at', '<=', now())
            ->where('id', '!=', $postId)
            ->orderByDesc('views')
            ->with(['category', 'tags', 'user'])
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

        return view('post.index', compact('post', 'recommendedPosts', 'mostViewedPosts'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.form')->with('error', 'Você precisa estar logado para criar um post.');
        }

        $categories = Category::all();
        $tags = Tag::all();
        
        return view('post.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'cover_path' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|in:draft,published',
        ], [
            'title.required' => 'O título é obrigatório.',
            'description.max' => 'A descrição não pode ter mais de 255 caracteres.',
            'content.required' => 'O conteúdo é obrigatório.',
            'category_id.required' => 'A categoria é obrigatória.',
            'tags.array' => 'As tags devem ser um array.',
            'cover_path.image' => 'A imagem deve ser uma imagem válida.',
            'cover_path.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif.',
            'cover_path.max' => 'A imagem não pode ter mais de 2MB.',
            'status.in' => 'O status deve ser "Rascunho" ou "Publicado".',
        ]);

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
        if (!$user) {
            return redirect()->route('login.form')->with('error', 'Você precisa estar logado para editar um post.');
        }
        $post = Post::findOrFail($id);
        if ($post->user_id !== $user->id) {
            return redirect()->route('post.show', $post->slug)->with('error', 'Você não tem permissão para editar este post.');
        }
        $categories = Category::all();
        $tags = Tag::all();

        return view('post.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.form')->with('error', 'Você precisa estar logado para editar um post.');
        }

        $post = Post::findOrFail($id);

        if ($post->user_id !== $user->id) {
            return redirect()->route('post.show', $post->slug)->with('error', 'Você não tem permissão para editar este post.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'cover_path' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|in:draft,published,archived',
        ], [
            'title.required' => 'O título é obrigatório.',
            'description.max' => 'A descrição não pode ter mais de 255 caracteres.',
            'content.required' => 'O conteúdo é obrigatório.',
            'category_id.required' => 'A categoria é obrigatória.',
            'tags.array' => 'As tags devem ser um array.',
            'cover_path.image' => 'A imagem deve ser uma imagem válida.',
            'cover_path.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif.',
            'cover_path.max' => 'A imagem não pode ter mais de 2MB.',
            'status.in' => 'O status deve ser "Rascunho", "Arquivado" ou "Publicado".',
        ]);

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
        $post = Post::findOrFail($id);

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
        if (!$user) {
            return redirect()->route('login.form')->with('error', 'Você precisa estar logado para excluir um post.');
        }

        $post = Post::findOrFail($id);

        if ($post->user_id !== $user->id) {
            return redirect()->route('post.show', $post->slug)->with('error', 'Você não tem permissão para excluir este post.');
        }
        
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
