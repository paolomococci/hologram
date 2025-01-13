<?php

use App\Livewire\UserInterface\Candidate\Register;
use Illuminate\Support\Facades\Route;
use App\Livewire\UserInterface\Employee\Login;
use App\Livewire\UserInterface\Catenaria\Welcome;

// welcome
Route::get('/', Welcome::class)->name('welcome');

// `login`
Route::get('/login', Login::class)->name('login');

// `register`
Route::get('/register', Register::class)->name('register');

// php artisan route:list
// php artisan route:cache && php artisan route:clear
