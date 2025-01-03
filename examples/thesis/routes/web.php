<?php

use App\Livewire\View\Dashboard;
use App\Livewire\Material\Workbench as MaterialDesignWorkbench;
use Illuminate\Support\Facades\Route;
use App\Livewire\Article\UploadImages;
use App\Livewire\Article\DownloadImages;
use App\Livewire\Article\Edit as EditArticle;
use App\Livewire\Article\Read as ReadArticle;
use App\Livewire\Article\Create as CreateArticle;
use App\Livewire\Article\Index as IndexOfArticles;
use App\Livewire\Playground\Message as PlaygroundSlotMessage;

// consolidated links
Route::get('/', IndexOfArticles::class);
Route::get('/articles/{article}', ReadArticle::class);

// TODO: link to be confirmed, I need to make the authentication logic to log in
Route::get('/dashboard', Dashboard::class)->name('dashboard.articles');
Route::get('/dashboard/article/create', CreateArticle::class);
Route::get('/dashboard/article/{article}/edit', EditArticle::class);
Route::get('/dashboard/article/{article}/upload-images', UploadImages::class);
Route::get('/dashboard/article/{article}/download-images', DownloadImages::class);

// Playground layout
Route::get('/playground', PlaygroundSlotMessage::class)->name('playground');

// Material Design layout
Route::get('/material', MaterialDesignWorkbench::class)->name('material');
