<?php

namespace App\Services;

use App\Models\Review;

class ReviewService
{
    public function create(array $data): bool|string
    {
        if (Review::isReviewExists($data['user_id'], $data['book_id'])) {
            return 'already_exists';
        }

        Review::create($data);

        return true;
    }

    public function update(Review $review, array $data): void
    {
        $review->update($data);
    }

    public function delete(Review $review): void
    {
        $review->delete();
    }
}
