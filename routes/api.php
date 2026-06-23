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

