<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\UserInterface\Catenaria\Welcome;

Route::get('/', Welcome::class)->name('welcome');
