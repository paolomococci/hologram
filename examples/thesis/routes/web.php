<?php

use App\Livewire\View\Dashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Article\UploadImages;
use App\Livewire\Authentication\Login;
use App\Livewire\Article\DownloadImages;
use App\Livewire\Authentication\Register;
use App\Livewire\Article\Edit as EditArticle;
use App\Livewire\Article\Read as ReadArticle;
use App\Http\Controllers\User\LogoutController;
use App\Livewire\Article\Create as CreateArticle;
use App\Livewire\Article\Index as IndexOfArticles;
use App\Livewire\Playground\Message as PlaygroundSlotMessage;
use App\Livewire\Material\Workbench as MaterialDesignWorkbench;

// `home`
Route::get('/', IndexOfArticles::class)->name('home');
// route accessible to all users dedicated to reading articles
Route::get('/articles/{article}', ReadArticle::class);

// `login`
Route::get('/login', Login::class)->name('login');

// `register`
Route::get('/register', Register::class)->name('register');

// here are three equivalent ways to log out and redirect to named route home.
// Route::get('/logout', function () {
//     Auth::logout();

//     return redirect()->route('home');
// });
// Route::get('/logout', fn () => LogoutController::signOut('home'));
Route::get('/logout', LogoutController::signOut('home'));

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
        Route::get('/dashboard/article/create', CreateArticle::class)->name('dashboard.article.create');
        Route::get('/dashboard/article/{article}/edit', EditArticle::class)->name('dashboard.article.edit');
        Route::get('/dashboard/article/{article}/upload-images', UploadImages::class)->name('dashboard.article.upload-images');
        Route::get('/dashboard/article/{article}/download-images', DownloadImages::class)->name('dashboard.article.download-images');
    }
);

// Don't forget to issue the following command from within the project:
// `php artisan route:clear && php artisan route:cache && php artisan route:list`
