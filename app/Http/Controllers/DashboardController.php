<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $books = auth()
            ->user()
            ->books()
            ->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')->orWhere('author', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString(); // Ensures pagination works with search

        $reviews = auth()
            ->user()
            ->reviews()
            ->latest()
            ->get();

        return inertia('Dashboard', [
            'books' => $books,
            'filters' => $request->only('search'), // Pass search input to Vue
            'reviews' => $reviews->load('book'),
        ]);
    }
}
