<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthWithMessage;
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
    Route::get('/criar', 'create')->name('create')->middleware(AuthWithMessage::class);
    Route::post('/criar', 'store')->name('store')->middleware(AuthWithMessage::class);
    Route::get('/edit/{id}', 'edit')->name('edit')->middleware(AuthWithMessage::class);
    Route::put('/edit/{id}', 'update')->name('update')->middleware(AuthWithMessage::class);
    Route::delete('/delete/image/{id}', 'destroyImage')->name('destroyImage')->middleware(AuthWithMessage::class);
    Route::delete('/delete/{id}', 'destroy')->name('destroy')->middleware(AuthWithMessage::class);
    Route::get('/{slug}', 'index')->name('show');
});

Route::group([
    'controller' => AuthController::class
], function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout')->middleware(AuthWithMessage::class);
});

Route::group([
    'controller' => UserController::class,
    'prefix' => 'profile',
    'as' => 'profile.'
], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/salvos', 'savedPosts')->name('savedPosts')->middleware(AuthWithMessage::class);
    Route::get('/{username}/following', 'following')->name('following');
    Route::get('/{username}/followers', 'followers')->name('followers');
    Route::get('/{username}', 'show')->name('show');
    Route::get('/{username}/edit', 'edit')->name('edit')->middleware(AuthWithMessage::class);
    Route::put('/{id}', 'update')->name('update')->middleware(AuthWithMessage::class);
    Route::delete('/image/{id}', 'destroyImage')->name('destroyImage')->middleware(AuthWithMessage::class);
    Route::delete('/{id}', 'destroy')->name('destroy')->middleware(AuthWithMessage::class);
});