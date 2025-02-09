<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::withAvg('reviews', 'rating')
            ->selectRaw('*, ROUND((SELECT AVG(rating) FROM reviews WHERE reviews.book_id = books.id), 1) AS reviews_avg_rating')
            ->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')->orWhere('author', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return inertia('Home', [
            'books' => $books,
            'filters' => $request->only('search'),
        ]);
    }

    public function review(Book $book)
    {
        return inertia('Review', [
            'book' => $book->load([
                'reviews' => function ($query) {
                    $query->latest();
                },
                'reviews.user',
            ]),
        ]);
    }
}
