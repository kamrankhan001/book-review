<?php

namespace App\Services;

use Illuminate\Http\Request;

class DashboardService
{
    public function getUserBooks(Request $request)
    {
        return auth()->user()
            ->books()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%'.$request->search.'%')
                        ->orWhere('author', 'like', '%'.$request->search.'%');
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();
    }

    public function getUserReviews()
    {
        return auth()->user()
            ->reviews()
            ->latest()
            ->with('book')
            ->get();
    }
}
