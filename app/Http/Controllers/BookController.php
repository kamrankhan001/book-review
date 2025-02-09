<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    public function store(BookRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id(); // Assign book to logged-in user

        // Handle image upload
        if ($request->hasFile('cover_image')) {
            $validatedData['cover_image'] = $this->handleImageUpload($request->file('cover_image'));
        }

        $newBook = Book::create($validatedData);

        return redirect()->back()->with(key: 'message', value: 'Book created successfully!',);
    }

    public function update(BookRequest $request, Book $book)
    {
        Gate::authorize(ability: 'update', arguments: $book);

        $validatedData = $request->validated();

        // Handle image upload
        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::delete(paths: $book->cover_image); // Delete old image
            }
            $validatedData['cover_image'] = $this->handleImageUpload($request->file(key: 'cover_image'));
        }else{
            $validatedData['cover_image'] = $book->cover_image;
        }

        $book->update($validatedData);

        return redirect()->back()->with(key: 'message', value: 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        Gate::authorize(ability: 'delete', arguments: $book);

        if ($book->cover_image) {
            Storage::delete($book->cover_image); // Delete the cover image
        }

        $book->delete();

        return redirect()->back()->with('message', 'Book deleted successfully.');
    }


    private function handleImageUpload($image)
    {
        return $image->store('books/covers', 'public'); // Save in storage/app/public/books/covers
    }
}
