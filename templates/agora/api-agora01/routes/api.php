<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RefusalController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

// This first route, being simply a test route, can be checked for functionality with the following command:
// curl --insecure --verbose https://api-agora01.hologram-srv.local/api/ping
Route::get('ping', function () {
    return json_encode([
        'status' => Response::HTTP_OK,
        'message' => 'The test endpoint named ping is working!',
    ]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('posts', PostsController::class);
Route::apiResource('refusals', RefusalController::class);

Route::post('/registration', [
    AuthenticationController::class,
    'registration',
]);

Route::post('/login', [
    AuthenticationController::class,
    'login',
]);

Route::post('/update-password', [
    AuthenticationController::class,
    'updatePassword',
])->middleware('auth:sanctum');

Route::post('/logout', [
    AuthenticationController::class,
    'logout',
])->middleware('auth:sanctum');

// Route::get('/posts', fn () => 'GET');

// if necessary
// php artisan route:cache && php artisan route:clear
