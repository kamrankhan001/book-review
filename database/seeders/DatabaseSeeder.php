<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call seeder
        $this->call(DemoUserSeeder::class);


        User::factory(5)->create()->each(function ($user) {
            $books = Book::factory(5)->create(['user_id' => $user->id]);

            // Each user reviews all their books
            $books->each(function ($book) use ($user) {
                Review::factory()->create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                ]);
            });
        });

    }
}
