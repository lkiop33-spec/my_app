<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/posts', [\App\Http\Controllers\PostController::class, 'store']);

Route::post('/working_lists', [\App\Http\Controllers\Api\WorkingListApiController::class, 'store']);
Route::get('/working_lists/latest', [\App\Http\Controllers\Api\WorkingListApiController::class, 'latest']);

Route::get('/users', [\App\Http\Controllers\Api\UserApiController::class, 'index']);

Route::get('/pcb-images', [\App\Http\Controllers\Api\PcbImageApiController::class, 'index']);
Route::get('/doc-images', [\App\Http\Controllers\Api\DocImageApiController::class, 'index']);
Route::get('/image/{type}/{filename}', [\App\Http\Controllers\Api\ImageServeApiController::class, 'show'])->name('api.image.show');


