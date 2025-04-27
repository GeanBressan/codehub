<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/posts/{slug}', [SiteController::class, 'show'])->name('post.show');
Route::get('/categories/{slug}', [SiteController::class, 'category'])->name('category.show');
Route::get('/tags/{slug}', [SiteController::class, 'tag'])->name('tag.show');