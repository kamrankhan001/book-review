<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    protected BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function store(BookRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $this->bookService->store($data, $request->file('cover_image'));

        return redirect()->back()->with('message', 'Book created successfully!');
    }

    public function update(BookRequest $request, Book $book)
    {
        Gate::authorize('update', $book);

        $data = $request->validated();

        $this->bookService->update($book, $data, $request->file('cover_image'));

        return redirect()->back()->with('message', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        Gate::authorize('delete', $book);

        $this->bookService->delete($book);

        return redirect()->back()->with('message', 'Book deleted successfully.');
    }
}
