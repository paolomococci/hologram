<?php

use App\Http\Controllers\Rest\ArticleRestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* articles API */

Route::get('/articles', [ArticleRestController::class, 'index'])->middleware('auth:sanctum');

Route::post('/articles', [ArticleRestController::class, 'store'])->middleware('auth:sanctum');
