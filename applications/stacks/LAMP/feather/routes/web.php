<?php

use App\Livewire\Search;
use App\Livewire\ShowTask;
use Illuminate\Support\Facades\Route;

Route::get('/', Search::class)->name('home');

Route::get('/tasks/{id}', ShowTask::class);

// commands to regenerate routes
// php artisan route:clear && php artisan route:cache
