<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Rest\PostsRestController;
use App\Http\Controllers\Rest\RefusalRestController;
use App\Http\Middleware\CheckTokenVersion;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

// This first route, being simply a test route, can be checked for functionality with the following command:
// curl --insecure --verbose https://chirps-hologram-srv.local/api/ping
Route::get('ping', function () {
    return json_encode([
        'status' => Response::HTTP_OK,
        'message' => 'The test endpoint named ping is working!',
    ]);
});

// List of routes for user management with reduced functionality on bones.
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout']);
Route::put('update', [AuthController::class, 'update']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('whoami', [AuthController::class, 'whoami']);

// RESTful routes related to resource Posts.
Route::get('posts', [PostsRestController::class, 'index']);
Route::post('post', [PostsRestController::class, 'store'])->middleware(CheckTokenVersion::class);
Route::get('post/{id}', [PostsRestController::class, 'show']);
Route::put('post/{id}', [PostsRestController::class, 'update'])->middleware(CheckTokenVersion::class);
Route::delete('post/{id}', [PostsRestController::class, 'destroy'])->middleware(CheckTokenVersion::class);

// RESTful routes related to resource Refusal.
Route::get('refusals', [RefusalRestController::class, 'index']);
Route::get('refusal/{id}', [RefusalRestController::class, 'show']);

// When necessary, I can send the following command:
// php artisan route:clear
// Or alternatively the following command to generate a route cache:
// php artisan route:clear && php artisan route:cache
// to significantly reduce response times.
