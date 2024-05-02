<?php

use App\Http\Controllers\ArticleController;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* articles API */

Route::get('/articles', function () {
    return Article::all();
})->middleware('auth:sanctum');

Route::post('/articles', [ArticleController::class, 'store'])->middleware('auth:sanctum');
