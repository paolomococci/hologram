<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\PaperController;

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
    Route::get(
        '/authors',
        [AuthorController::class, 'index']
    )->name('authors');
    Route::post(
        '/authors',
        [AuthorController::class, 'store']
    )->name('authors-store');
    Route::put(
        '/authors',
        [AuthorController::class, 'update']
    )->name('authors-update');
    Route::get(
        '/authors/filter',
        [AuthorController::class, 'filter']
    )->name('authors-filter');
    Route::get(
        '/authors/show/{id}',
        [AuthorController::class, 'show']
    )->name('authors-show');

    /* tab: Article */
    Route::get(
        '/articles',
        [ArticleController::class, 'index']
    )->name('articles');
    Route::post(
        '/articles',
        [ArticleController::class, 'store']
    )->name('articles-store');
    Route::put(
        '/articles',
        [ArticleController::class, 'update']
    )->name('articles-update');
    Route::get(
        '/articles/filter',
        [ArticleController::class, 'filter']
    )->name('articles-filter');
    Route::get(
        '/articles/show/{id}',
        [ArticleController::class, 'show']
    )->name('articles-show');

    /* tab: Paper */
    Route::get('/papers', function () {
        return Inertia::render('Tabs/Papers/PaperTab');
    })->name('papers');
    Route::post(
        '/papers',
        [PaperController::class, 'store']
    )->name('papers-store');

    /* tab: Tool */
    Route::get('/tools', function () {
        return Inertia::render('Tabs/Tools/ToolTab');
    })->name('tools');

    /* tools controller */
    Route::get('/renumber', [ToolController::class, 'renumber'])->name('renumber');
    Route::get('/clean', [ToolController::class, 'clean'])->name('clean');

    /* tab: Extension */
    Route::get(
        '/extensions',
        [ExtensionController::class, 'index']
    )->name('extensions');
    Route::post(
        '/echo',
        [ExtensionController::class, 'echo']
    )->name('echo');
});
