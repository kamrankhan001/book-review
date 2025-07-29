<?php

use App\Models\User;

it('shows user dashboard with books and reviews', function () {
    $user = User::factory()->hasBooks(2)->hasReviews(2)->create();

    $this->actingAs($user);

    $response = $this->get(route('dashboard'));

    $response->assertOk();
    $response->assertInertia(fn ($page) => 
        $page->component('Dashboard')
             ->has('books.data', 2)
             ->has('reviews', 2)
    );
});
