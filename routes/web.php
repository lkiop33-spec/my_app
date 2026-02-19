<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 간단 게시판
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    Route::resource('geades', \App\Http\Controllers\GeadeController::class)->only(['index', 'store', 'destroy']);

    // 사용자 관리
    Route::resource('users', \App\Http\Controllers\UserController::class)->only(['index', 'show']);
    Route::post('/users/{user}/rank', [\App\Http\Controllers\UserController::class, 'updateRank'])->name('users.updateRank');
});

require __DIR__.'/auth.php';
