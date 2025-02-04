<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use App\Http\Middleware\CheckTokenVersion;
use App\Http\Controllers\RefusalController;
use Illuminate\Http\Response;

// This first route, being simply a test route, can be checked for functionality with the following command:
// curl --insecure --verbose https://chirps-hologram-srv.local/api/ping
Route::get('ping', function () {
    return response()->json([
        'status' => 'success',
        'response' => 'At work!',
    ], Response::HTTP_OK);
});

// List of routes for user management with reduced functionality on bones.
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout']);
Route::put('update', [AuthController::class, 'update']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('whoami', [AuthController::class, 'whoami']);

// RESTful routes related to resource Posts.
Route::get('posts', [PostsController::class, 'index'])->middleware(CheckTokenVersion::class);
Route::post('post', [PostsController::class, 'store'])->middleware(CheckTokenVersion::class);
Route::get('post/{id}', [PostsController::class, 'show'])->middleware(CheckTokenVersion::class);
Route::put('post/{id}', [PostsController::class, 'update'])->middleware(CheckTokenVersion::class);
Route::delete('post/{id}', [PostsController::class, 'destroy'])->middleware(CheckTokenVersion::class);

// RESTful routes related to resource Refusal.
Route::get('refusals', [RefusalController::class, 'index'])->middleware(CheckTokenVersion::class);
Route::get('refusal/{id}', [RefusalController::class, 'show'])->middleware(CheckTokenVersion::class);

// When necessary, I can send the following command:
// php artisan route:clear
// Or alternatively the following command to generate a route cache:
// php artisan route:clear && php artisan route:cache
// to significantly reduce response times.
