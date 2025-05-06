<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $request->validated();

        $slugBase = Str::slug($request->name, '');
        $slug = $slugBase;

        $counter = 1;
        while (User::where('username', $slug)->exists()) {
            $slug = $slugBase . $counter;
            $counter++;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $slug,
        ]);

        Auth::login($user);

        return redirect(route('home'))->with('success', 'Seja bem-vindo ' . $user->name . '!');
    }

    public function login(LoginRequest $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'password.required' => 'Password is required.',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect(route('home'))->with('success', 'Seja bem-vindo ' . Auth::user()->name . '!');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials.']);
    }


    public function logout()
    {
        $user = User::find(Auth::id());
        Auth::logout();
        return redirect(route('home'))->with('success', 'Ate logo!');
    }
}
