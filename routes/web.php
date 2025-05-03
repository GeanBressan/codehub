<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/categories/{slug}', [SiteController::class, 'category'])->name('category.show');
Route::get('/tags/{slug}', [SiteController::class, 'tag'])->name('tag.show');

Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');
Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');

Route::group([
    'controller' => PostController::class,
    'prefix' => 'post',
    'as' => 'post.'
], function () {
    Route::get('/criar', 'create')->name('create');
    Route::post('/criar', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::put('/edit/{id}', 'update')->name('update');
    Route::delete('/delete/image/{id}', 'destroyImage')->name('destroyImage');
    Route::delete('/delete/{id}', 'destroy')->name('destroy');
    Route::get('/{slug}', 'index')->name('show');
});

Route::group([
    'controller' => AuthController::class
], function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::group([
    'controller' => UserController::class,
    'prefix' => 'profile',
    'as' => 'profile.'
], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{username}', 'show')->name('show');
    Route::get('/{username}/edit', 'edit')->name('edit');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/image/{id}', 'destroyImage')->name('destroyImage');
    Route::delete('/{id}', 'destroy')->name('destroy');
});