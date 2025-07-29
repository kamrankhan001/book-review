<?php

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

it('stores a new book with image', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $file = UploadedFile::fake()->image('cover.jpg');

    $response = $this->post(route('books.store'), [
        'title' => 'Test Book',
        'author' => 'Test Author',
        'cover_image' => $file,
    ]);

    $response->assertRedirect();
    expect(Book::first())->title->toBe('Test Book');
    Storage::disk('public')->assertExists('books/covers/'.$file->hashName());
});

it('updates an existing book', function () {
    $user = User::factory()->create();
    $book = Book::factory()->for($user)->create();
    $this->actingAs($user);

    $response = $this->post(route('books.update', $book), [
        'title' => 'Updated Title',
        'author' => 'Updated Author',
    ]);

    $response->assertRedirect();
    expect($book->fresh()->title)->toBe('Updated Title');
});

it('deletes a book', function () {
    $user = User::factory()->create();
    $book = Book::factory()->for($user)->create();
    $this->actingAs($user);

    $response = $this->delete(route('books.destroy', $book));

    $response->assertRedirect();
    $this->assertDatabaseMissing('books', ['id' => $book->id]);
});
