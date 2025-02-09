<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request)
    {
        if (Review::isReviewExists($request->user_id, $request->book_id)) {
            return redirect()->back()->with('message', 'yes');
        }

        Review::create($request->validated());

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
        Gate::authorize(ability: 'delete', arguments: $review);

        $review->delete();

        return redirect()->back()->with('message', 'Review deleted successfully');
    }
}
