<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RefusalController;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

// This first route, being simply a test route, can be checked for functionality with the following command:
// curl --insecure --verbose https://api-agora01.hologram-srv.local/api/ping
Route::get('ping', function (): string {
    return json_encode([
        'status' => Response::HTTP_OK,
        'message' => 'The test endpoint named ping is working!',
    ]);
});

// Total number of non-deprecated posts:
// curl --insecure --verbose https://api-agora01.hologram-srv.local/api/num-of-posts
Route::get('num-of-posts', function (): string {
    return json_encode([
        'status' => Response::HTTP_OK,
        'num' => Posts::count(),
    ]);
});

// TODO: `filtered` API
// curl --insecure --verbose https://api-agora01.hologram-srv.local/api/filtered?starting=0&until=100&filter=alice
Route::get('filtered', function (int $starting = 0, int $until = 100, string $filter = ""): string {
    return json_encode([
        'status' => Response::HTTP_NOT_IMPLEMENTED
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
