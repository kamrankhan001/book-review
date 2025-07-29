<?php

namespace App\Actions;

use App\Models\Book;
use Illuminate\Http\Request;

class GetFilteredBooksAction
{
    public function __invoke(Request $request)
    {
        $search = $request->input('search');

        return Book::withAvg('reviews', 'rating')
            ->selectRaw('*, ROUND((SELECT AVG(rating) FROM reviews WHERE reviews.book_id = books.id), 1) AS reviews_avg_rating')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();
    }
}
