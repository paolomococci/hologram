<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    // Help tab
    Route::get('/help', function () {
        return Inertia::render('Tabs/Help/HelpTab');
    })->name('help');
    // Template tab
    Route::get('/template', function () {
        return Inertia::render('Tabs/Template/TemplateTab');
    })->name('template');
});
