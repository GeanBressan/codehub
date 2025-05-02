<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
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
        $loggedUserID = (auth()->user()) ? auth()->user()->id : null;
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Usuário não encontrado.');
        }

        $posts = Post::where('user_id', $user->id)
            ->with(['category', 'tags'])
            ->latest()
            ->paginate(10);

        return view('profile.index', compact('loggedUserID', 'user', 'posts'));
    }

    public function edit($username)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Usuário não encontrado.');
        }

        if ($user->username !== $username) {
            return redirect()->route('home')->with('error', 'Você não tem permissão para editar este perfil.');
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Usuário não encontrado.');
        }

        if ($user->id !== (int)$id) {
            return redirect()->route('home')->with('error', 'Você não tem permissão para editar este perfil.');
        }

        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'cover_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',
            'name.min' => 'O campo nome deve ter pelo menos 3 caracteres.',
            'username.required' => 'O campo nome de usuário é obrigatório.',
            'username.unique' => 'Este nome de usuário já está em uso.',
            'bio.max' => 'A biografia não pode ter mais de 500 caracteres.',
            'cover_path.image' => 'O arquivo deve ser uma imagem.',
            'cover_path.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif.',
            'cover_path.max' => 'A imagem não pode ter mais de 2MB.',
        ]);

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

        if (!$user) {
            return redirect()->route('home')->with('error', 'Usuário não encontrado.');
        }

        if ($user->id !== (int)$id) {
            return redirect()->route('home')->with('error', 'Você não tem permissão para editar este perfil.');
        }

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

        if (!$user) {
            return redirect()->route('home')->with('error', 'Usuário não encontrado.');
        }

        if ($user->id !== (int) $id) {
            return redirect()->route('home')->with('error', 'Você não tem permissão para deletar este perfil.');
        }

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
