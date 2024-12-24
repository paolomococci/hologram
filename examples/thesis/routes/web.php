<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Article\Read as ReadArticle;
use App\Livewire\Article\Index as IndexOfArticles;
use App\Livewire\Article\Create as CreateArticle;
use App\Livewire\Article\Edit as EditArticle;
use App\Livewire\View\Dashboard;

// consolidated links
Route::get('/', IndexOfArticles::class);
Route::get('/articles/{article}', ReadArticle::class);

// TODO: link to be confirmed, I need to make the authentication logic to log in
Route::get('/dashboard', Dashboard::class);
Route::get('/dashboard/article/create', CreateArticle::class);
Route::get('/dashboard/article/{article}/edit', EditArticle::class);
