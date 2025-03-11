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

// `filtered` API
// curl --insecure --verbose https://api-agora01.hologram-srv.local/api/filtered/caterpillar/1
Route::get('filtered/{filter?}/{current?}', function (
    string $filter = "none",
    int $current = 1
): string {
    $offset = 10 * ($current - 1);
    if ($filter != 'none') {
        $totalNumberOfPosts = Posts::where('title', 'like', "%$filter%")->with('user')->get()->count();
        $posts = Posts::where('title', 'like', "%$filter%")->with('user')->latest()->offset($offset)->limit(10)->get();
    } else {
        $totalNumberOfPosts = Posts::with('user')->get()->count();
        $posts = Posts::with('user')->latest()->offset($offset)->limit(10)->get();
    }

    return json_encode([
        'status' => Response::HTTP_OK,
        'num' => $totalNumberOfPosts,
        'posts' => $posts
    ]);
});

// `paginator` API
// curl --insecure --verbose https://api-agora01.hologram-srv.local/api/paginator/1?filter=caterpillar
Route::get('paginator/{current?}', function (
    int $current = 1
): string {
    $offset = 10 * ($current - 1);
    $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
    if ($filter != '') {
        $totalNumberOfPosts = Posts::where('title', 'like', "%$filter%")->with('user')->get()->count();
        $posts = Posts::where('title', 'like', "%$filter%")->with('user')->latest()->offset($offset)->limit(10)->get();
    } else {
        $totalNumberOfPosts = Posts::with('user')->get()->count();
        $posts = Posts::with('user')->latest()->offset($offset)->limit(10)->get();
    }

    return json_encode([
        'status' => Response::HTTP_OK,
        'num' => $totalNumberOfPosts,
        'posts' => $posts
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
