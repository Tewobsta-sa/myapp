<?php

use App\Http\Controllers\Auth\AUthenticationController;
use App\Http\Controllers\Feed\FeedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function(){
    return response([
        'message' => 'API is working'
    ], 200);
});

Route::post('/register', [AUthenticationController::class, 'register']);
Route::post('/login', [AUthenticationController::class, 'login']);
Route::post('/feed/store', [FeedController::class, 'store'])->middleware('auth:sanctum');
Route::post('/feed/like/{feed_id}', [FeedController::class, 'likePost'])->middleware('auth:sanctum');
Route::post('/feed/comment/{feed_id}', [FeedController::class, 'comment'])->middleware('auth:sanctum');
Route::get('/feed/comment/{feed_id}', [FeedController::class, 'getComments'])->middleware('auth:sanctum');
Route::get('/feeds', [FeedController::class, 'index'])->middleware('auth:sanctum');
