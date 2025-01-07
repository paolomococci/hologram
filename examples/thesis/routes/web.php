<?php

use App\Livewire\Article\Create as CreateArticle;
use App\Livewire\Article\DownloadImages;
use App\Livewire\Article\Edit as EditArticle;
use App\Livewire\Article\Index as IndexOfArticles;
use App\Livewire\Article\Read as ReadArticle;
use App\Livewire\Article\UploadImages;
use App\Livewire\Authentication\Login;
use App\Livewire\Authentication\Register;
use App\Livewire\Material\Workbench as MaterialDesignWorkbench;
use App\Livewire\Playground\Message as PlaygroundSlotMessage;
use App\Livewire\View\Dashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// `home`
Route::get('/', IndexOfArticles::class)->name('home');
// route accessible to all users dedicated to reading articles
Route::get('/articles/{article}', ReadArticle::class);

// `login`
Route::get('/login', Login::class)->name('login');

// `register`
Route::get('/register', Register::class)->name('register');

// `logout` redirects to the path named `home`
Route::get('/logout', function () {
    Auth::logout();

    return redirect()->route('home');
});

// playground layout route dedicated to layout development
Route::get('/playground', PlaygroundSlotMessage::class)->name('playground');

// material design layout route dedicated to the development of components
Route::get('/material', MaterialDesignWorkbench::class)->name('material');

// paths that require registration and authentication

Route::middleware([
    'auth',
])->group(
    function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard.articles');
        Route::get('/dashboard/article/create', CreateArticle::class);
        Route::get('/dashboard/article/{article}/edit', EditArticle::class);
        Route::get('/dashboard/article/{article}/upload-images', UploadImages::class);
        Route::get('/dashboard/article/{article}/download-images', DownloadImages::class);
    }
);

// Don't forget to issue the following command from within the project:
// `php artisan route:clear && php artisan route:cache && php artisan route:list`
