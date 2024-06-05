<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->post('/register', [AuthController::class, 'register']);
Route::middleware('auth:api')->post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/comments', [CommentController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
    Route::post('/comments/{comment}/like', [LikeController::class, 'store']);  
    Route::delete('/comments/{comment}/unlike', [LikeController::class, 'destroy']); 
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::put('/user/{id}/update', [UserController::class, 'update']);
    Route::get('/users', [UserController::class, 'index']);
});

