<?php

use App\Models\User;
use App\Models\Book;
use App\Models\Review;

it('stores a review', function () {
    $user = User::factory()->create();
    $book = Book::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('book-review.store'), [
        'user_id' => $user->id,
        'book_id' => $book->id,
        'rating' => '4.5', // Must be a string to pass regex /^\d(\.\d)?$/
        'review' => 'Good book!', // Must match 'review' key
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('reviews', [
        'user_id' => $user->id,
        'book_id' => $book->id,
        'review' => 'Good book!',
        'rating' => 4.5,
    ]);
});

it('prevents duplicate reviews', function () {
    $user = User::factory()->create();
    $book = Book::factory()->create();
    Review::factory()->create([
        'user_id' => $user->id,
        'book_id' => $book->id,
    ]);

    $this->actingAs($user);

    $response = $this->post(route('book-review.store'), [
        'user_id' => $user->id,
        'book_id' => $book->id,
        'rating' => '4.5',
        'review' => 'Duplicate review',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('message', 'You already submitted a review for this book.');
});

it('updates a review', function () {
    $review = Review::factory()->create([
        'rating' => 4.0,
        'review' => 'Initial comment',
    ]);

    $this->actingAs($review->user);

    $response = $this->put(route('book-review.update', $review), [
        'user_id' => $review->user_id,
        'book_id' => $review->book_id,
        'rating' => '3.5',
        'review' => 'Updated comment!',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('reviews', [
        'id' => $review->id,
        'review' => 'Updated comment!',
        'rating' => 3.5,
    ]);
});

it('deletes a review', function () {
    $review = Review::factory()->create();
    $this->actingAs($review->user);

    $response = $this->delete(route('book-review.destroy', $review));

    $response->assertRedirect();
    $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
});
