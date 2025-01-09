<?php

use App\Livewire\UserInterface\Catenaria\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('welcome');
