<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* articles API */

Route::post('/articles', [ArticleController::class, 'store'])->middleware('auth:sanctum');
