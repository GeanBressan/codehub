<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('home')->with('error', 'Usuário não encontrado.');
        }

        return redirect()->route('profile.show', $user->username);
    }

    public function show($username)
    {
        $user = User::where('username', $username)
        ->withCount('posts as posts_count')
        ->withCount('followers as followers_count')
        ->withCount('following as following_count')
        ->with(['followers', 'following'])
        ->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Usuário não encontrado.');
        }

        $posts = Post::where('user_id', $user->id)
            ->with(['category', 'tags'])
            ->withCount('likedByUsers as likes_count')
            ->withCount('comments as comments_count')
            ->latest()
            ->paginate(10);

        return view('profile.index', compact('user', 'posts'));
    }

    public function savedPosts()
    {
        $user = Auth::user();

        $this->authorize('view', $user);
        
        $posts = $user->savedPosts()->where("status", "=" , "published")->with(['user', 'tags', 'category'])->withCount('likedByUsers as likes_count')->latest()->paginate(9);
        return view('profile.saved-posts', compact('posts'));
    }

    public function following($username)
    {
        $user = User::where('username', $username)
            ->withCount('posts as posts_count')
            ->withCount('followers as followers_count')
            ->withCount('following as following_count')
            ->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Usuário não encontrado.');
        }

        $title = 'Seguindo';

        $followList = $user->following()->latest()->paginate(9);

        return view('profile.follows-list', compact('followList', 'user', 'title'));
    }

    public function followers($username)
    {
        $user = User::where('username', $username)
            ->withCount('posts as posts_count')
            ->withCount('followers as followers_count')
            ->withCount('following as following_count')
            ->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Usuário não encontrado.');
        }

        $title = 'Seguidores';

        $followList = $user->followers()->latest()->paginate(9);

        return view('profile.follows-list', compact('followList', 'user', 'title'));
    }

    public function edit($username)
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        return view('profile.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        $request->validated();

        $user->name = $request->name;
        $user->username = $request->username;
        $user->bio = $request->bio;
        
        if ($request->hasFile('cover_path')) {
            if ($user->cover_path) {
                $oldPath = public_path('storage/' . $user->cover_path);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $fileName = $user->username . '-' . time() . '.' . $request->file('cover_path')->getClientOriginalExtension();
            $request->file('cover_path')->move(public_path('storage/images/users'), $fileName);
            $user->cover_path = 'images/users/' . $fileName;
        }

        if (!$user->save()) {
            return redirect()->back()->with('error', 'Erro ao atualizar o perfil. Tente novamente.');
        }

        return redirect()->route('profile.show', $user->username)->with('success', 'Perfil atualizado com sucesso.');
    }

    public function destroyImage($id)
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        if ($user->cover_path) {
            $oldPath = public_path('storage/' . $user->cover_path);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
            $user->cover_path = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto de perfil removida com sucesso.');
    }

    public function destroy(Request $request, $id)
    {
        $user = auth()->user();

        $this->authorize('delete', $user);

        if ($user->cover_path) {
            $oldPath = public_path('storage/' . $user->cover_path);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
            $user->cover_path = null;
            $user->save();
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect()->route('home')->with('success', 'Usuário excluído com sucesso.');
    }
}
