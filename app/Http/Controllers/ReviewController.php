<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    protected ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function store(ReviewRequest $request)
    {
        $result = $this->reviewService->create($request->validated());

        if ($result === 'already_exists') {
            return redirect()->back()->with('message', 'You already submitted a review for this book.');
        }

        return redirect()->back()->with('message', 'Review added successfully.');
    }

    public function update(ReviewRequest $request, Review $review)
    {
        $this->reviewService->update($review, $request->validated());

        return redirect()->back()->with('message', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        Gate::authorize('delete', $review);

        $this->reviewService->delete($review);

        return redirect()->back()->with('message', 'Review deleted successfully.');
    }
}
