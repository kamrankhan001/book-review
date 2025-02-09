<?php

namespace App\Policies;

use App\Models\{User, Review};

class ReviewPolicy
{
    public function create(User $user): bool
    {
        return $user->exists;
    }

    public function update(User $user, Review $review): bool
    {
        return $user->id === $review->user_id;
    }

    public function delete(User $user, Review $review): bool
    {
        return $user->id === $review->user_id;
    }
}
