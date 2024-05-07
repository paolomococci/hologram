<?php

use Inertia\Inertia;
use App\Models\Article;
use App\Utils\SanitizerUtil;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ArticleController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    /* tab: Help */
    Route::get('/help', function () {
        return Inertia::render('Tabs/Help/HelpTab');
    })->name('help');

    /* tab: Author */
    Route::get('/authors', function () {
        return Inertia::render('Tabs/Authors/AuthorTab');
    })->name('authors');

    /* tab: Article */
    Route::get(
        '/articles',
        [ArticleController::class, 'index']
    )->name('articles');
    Route::post(
        '/articles',
        [ArticleController::class, 'store']
    )->name('articles');
    Route::get(
        '/articles/filter', [ArticleController::class, 'filter']
    )->name('articles-filter');

    /* articles controller */
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles');

    /* tab: Paper */
    Route::get('/papers', function () {
        return Inertia::render('Tabs/Papers/PaperTab');
    })->name('papers');

    /* tab: Tool */
    Route::get('/tools', function () {
        return Inertia::render('Tabs/Tools/ToolTab');
    })->name('tools');

    /* tools controller */
    Route::get('/renumber', [ToolController::class, 'renumber'])->name('renumber');
    Route::get('/clean', [ToolController::class, 'clean'])->name('clean');
});
