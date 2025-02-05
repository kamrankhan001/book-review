<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bookCovers = ['book1.jpg', 'book2.jpg', 'book3.jpg', 'book4.jpg', 'book5.jpg', 'book6.jpg'];

        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name,
            'cover_image' => 'books/covers/' . $bookCovers[array_rand($bookCovers)],
            'description' => $this->faker->words(15, true),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
