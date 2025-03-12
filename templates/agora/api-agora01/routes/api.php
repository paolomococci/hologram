<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\EcosystemController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RefusalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// This first route, being simply a test route, can be checked for functionality with the following command:
// curl --insecure --verbose https://api-agora01.hologram-srv.local/api/ping
Route::get('ping', [EcosystemController::class, 'ping']);

// Total number of non-deprecated posts:
// curl --insecure --verbose https://api-agora01.hologram-srv.local/api/stored
Route::get('stored', [EcosystemController::class, 'stored']);

// `filtered` API
// curl --insecure --verbose https://api-agora01.hologram-srv.local/api/filtered/caterpillar/1
Route::get('filtered/{filter?}/{current?}', [EcosystemController::class, 'filtered']);

// `paginate` API
// curl --insecure --verbose https://api-agora01.hologram-srv.local/api/paginate/1?filter=caterpillar
Route::get('paginate/{current?}', [EcosystemController::class, 'paginate']);

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
