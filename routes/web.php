<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/posts/{slug}', [SiteController::class, 'show'])->name('post.show');
Route::get('/categories/{slug}', [SiteController::class, 'category'])->name('category.show');
Route::get('/tags/{slug}', [SiteController::class, 'tag'])->name('tag.show');


Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');
Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');

Route::group([
    'controller' => AuthController::class
], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group([
    'controller' => UserController::class,
    'prefix' => 'profile',
    'as' => 'profile.'
], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/{username}', [UserController::class, 'show'])->name('show');
    Route::get('/{username}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/image/{id}', [UserController::class, 'destroyImage'])->name('destroyImage');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
});