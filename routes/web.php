<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/book/review/{book}', [HomeController::class, 'review'])->name('book-review');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/book/review/store', [HomeController::class, 'storeReview'])->name('book-review.store');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::post('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
