<?php

use App\Livewire\Task;
use App\Livewire\Search;
use App\Livewire\EditTask;
use App\Livewire\ShowTask;
use App\Livewire\CreateTask;
use Illuminate\Support\Facades\Route;

Route::get('/', Search::class)->name('home');

// In this case I use the placeholder id; in this case, in the controller, I will need to perform an explicit query.
Route::get('/tasks/{id}', ShowTask::class)->name('show-task');

Route::get('/create', CreateTask::class)->name('create-task');

// In this case I use the placeholder task thanks to implicit model binding in the route.
Route::get('/edit/{task}', EditTask::class)->name('edit-task');

// commands to regenerate the routes
// php artisan route:clear && php artisan route:cache
// Command to view the list of routes.
// php artisan route:list
