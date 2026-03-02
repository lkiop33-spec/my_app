<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\WsspDashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/wssp/dashboard', [\App\Http\Controllers\WsspDashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('wssp.dashboard');

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
    Route::post('/users/{user}/department', [\App\Http\Controllers\UserController::class, 'updateDepartment'])->name('users.updateDepartment');

    // 부서 관리
    Route::resource('departments', \App\Http\Controllers\DepartmentController::class)->only(['index', 'store', 'destroy']);

    // 공지사항
    Route::resource('notices', \App\Http\Controllers\NoticeController::class);
    // 추가된 13개 테이블 웹 라우트
    Route::resource('locations', \App\Http\Controllers\LocationController::class);
    Route::resource('parts', \App\Http\Controllers\PartController::class);
    Route::resource('levels', \App\Http\Controllers\LevelController::class);
    Route::resource('work_lists', \App\Http\Controllers\WorkListController::class);
    Route::resource('pcb_tables', \App\Http\Controllers\PcbTableController::class);
    Route::resource('part_tables', \App\Http\Controllers\PartTableController::class);
    Route::resource('process_tables', \App\Http\Controllers\ProcessTableController::class);
    Route::resource('pcb_image_tables', \App\Http\Controllers\PcbImageTableController::class);
    Route::resource('doc_lists', \App\Http\Controllers\DocListController::class);
    Route::resource('types', \App\Http\Controllers\TypeController::class);
    Route::resource('languages', \App\Http\Controllers\LanguageController::class);
    Route::resource('forbiddens', \App\Http\Controllers\ForbiddenController::class);
    Route::resource('devices', \App\Http\Controllers\DeviceController::class);
});

require __DIR__.'/auth.php';
