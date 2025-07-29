<?php

use App\Models\Book;

it('displays the homepage with books', function () {
    $book = Book::factory()->create();
    
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertInertia(fn ($page) => 
        $page->component('Home')
             ->has('books.data', 1)
             ->where('filters', [])
    );
});

it('filters books by search', function () {
    Book::factory()->create(['title' => 'Laravel Testing']);
    Book::factory()->create(['title' => 'Vue Guide']);

    $response = $this->get(route('home', ['search' => 'Laravel']));

    $response->assertInertia(fn ($page) => 
        $page->has('books.data', 1)
    );
});
