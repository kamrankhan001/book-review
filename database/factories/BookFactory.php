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
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name,
            'cover_image' => $this->faker->imageUrl(200, 300, 'books', true), // Random book image
            'description' => $this->faker->paragraph,
            'user_id' => \App\Models\User::factory(), // Assign a user
        ];
    }
}
