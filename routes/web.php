<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/posts/{slug}', [SiteController::class, 'show'])->name('post.show');
Route::get('/categories/{slug}', [SiteController::class, 'category'])->name('category.show');
Route::get('/tags/{slug}', [SiteController::class, 'tag'])->name('tag.show');

Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');