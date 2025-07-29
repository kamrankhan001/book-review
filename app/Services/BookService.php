<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BookService
{
    public function store(array $data, ?UploadedFile $image = null): Book
    {
        if ($image) {
            $data['cover_image'] = $this->uploadCoverImage($image);
        }

        return Book::create($data);
    }

    public function update(Book $book, array $data, ?UploadedFile $image = null): Book
    {
        if ($image) {
            if ($book->cover_image) {
                Storage::delete($book->cover_image);
            }
            $data['cover_image'] = $this->uploadCoverImage($image);
        } else {
            $data['cover_image'] = $book->cover_image;
        }

        $book->update($data);
        return $book;
    }

    public function delete(Book $book): void
    {
        if ($book->cover_image) {
            Storage::delete($book->cover_image);
        }

        $book->delete();
    }

    protected function uploadCoverImage(UploadedFile $image): string
    {
        return $image->store('books/covers', 'public');
    }
}
