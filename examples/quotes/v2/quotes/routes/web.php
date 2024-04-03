<?php

use App\Http\Controllers\SampleController;
use App\Models\Sample;
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
    // Dashboard tab
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Sample tab
    Route::get('/sample', function () {
        $samples = Sample::paginate(10)->through(fn ($sample) => [
            'id' => $sample->id,
            'title' => $sample->title,
            'subject' => $sample->subject,
        ]);
        return Inertia::render('Tabs/SampleTab', ['samples' => $samples]);
    })->name('sample');
    // Sample items thanks to the controller
    Route::get('/sample-index', [SampleController::class, 'index'])->name('sample-index');
    Route::get('/sample-filter', [SampleController::class, 'filter'])->name('sample-filter');
    Route::get('/sample-read/{id}', [SampleController::class, 'read'])->name('sample-read');
    Route::post('/sample-create', [SampleController::class, 'create'])->name('sample-create');
    Route::post('/sample-edit', [SampleController::class, 'edit'])->name('sample-edit');
});
