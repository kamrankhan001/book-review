<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController,DashboardController,ProfileController, BookController,ReviewController};


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/book/review/{book}', [HomeController::class, 'review'])->name('book-review');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/book/review/store', [ReviewController::class, 'store'])->name('book-review.store');
    Route::put('/book/review/edit/{review}', [ReviewController::class, 'update'])->name('book-review.update');
    Route::delete('/book/review/edit/{review}', [ReviewController::class, 'destroy'])->name('book-review.destroy');

    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::post('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
