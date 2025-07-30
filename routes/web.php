<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/book/review/{book}', [HomeController::class, 'review'])->name('book-review');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/book/review/store', [ReviewController::class, 'store'])
        ->middleware('throttle:5,1') // limit to 5 requests per minute
        ->name('book-review.store');

    Route::put('/book/review/edit/{review}', [ReviewController::class, 'update'])
        ->middleware('throttle:5,1')
        ->name('book-review.update');

    Route::delete('/book/review/edit/{review}', [ReviewController::class, 'destroy'])
        ->middleware('throttle:5,1')
        ->name('book-review.destroy');

    Route::post('/books', [BookController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('books.store');

    Route::post('/books/{book}', [BookController::class, 'update'])
        ->middleware('throttle:5,1')
        ->name('books.update');

    Route::delete('/books/{book}', [BookController::class, 'destroy'])
        ->middleware('throttle:5,1')
        ->name('books.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('demo.user');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('demo.user');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('demo.user');
});

Route::get('auth/google/redirect', [GoogleController::class, 'googleRedirect'])->name('auth.google');

Route::get('auth/google/callback', [GoogleController::class, 'googleCallback']);

require __DIR__.'/auth.php';
