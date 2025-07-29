<?php

namespace App\Http\Controllers;

use App\Actions\GetFilteredBooksAction;
use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request, GetFilteredBooksAction $getFilteredBooks)
    {
        $books = $getFilteredBooks($request);

        return inertia('Home', [
            'books' => $books,
            'filters' => $request->only('search'),
        ]);
    }

    public function review(Book $book)
    {
        $book->load([
            'reviews' => fn ($query) => $query->latest(),
            'reviews.user',
        ]);

        return inertia('Review', [
            'book' => $book,
        ]);
    }
}
