<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Models\{Book, Review};

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::where(function ($query) use ($request) {
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
