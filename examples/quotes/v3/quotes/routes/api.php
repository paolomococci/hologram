<?php

use App\Http\Controllers\Rest\ArticleRestController;
use App\Http\Controllers\Rest\AuthorRestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* authors API */
Route::post('/authors', [AuthorRestController::class, 'create'])->middleware('auth:sanctum');
Route::get('/authors/{id}', [AuthorRestController::class, 'read'])->middleware('auth:sanctum');
Route::get('/authors', [AuthorRestController::class, 'index'])->middleware('auth:sanctum');
Route::put('/authors/{id}', [AuthorRestController::class, 'update'])->middleware('auth:sanctum');

/* articles API */
Route::post('/articles', [ArticleRestController::class, 'create'])->middleware('auth:sanctum');
Route::get('/articles/{id}', [ArticleRestController::class, 'read'])->middleware('auth:sanctum');
Route::get('/articles', [ArticleRestController::class, 'index'])->middleware('auth:sanctum');
Route::put('/articles/{id}', [ArticleRestController::class, 'update'])->middleware('auth:sanctum');
