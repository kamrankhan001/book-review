<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;


class ReviewController extends Controller
{
    public function store(ReviewRequest $request)
    {
        $validatedData = $request->validated();

        Review::create($validatedData);
        return redirect()->back()->with('message', 'Review added successfully');
    }

    public function update(ReviewRequest $request, Review $review)
    {
        $validatedData = $request->validated();

        $review->update($validatedData);
        return redirect()->back()->with('message', 'Review updated successfully');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('message', 'Review deleted successfully');
    }
}
