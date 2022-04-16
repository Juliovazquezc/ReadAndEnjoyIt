<?php

namespace Database\Factories;

use App\Constants\BookStatus;
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
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->text(25),
            'author' => $this->faker->name(),
            'status' => BookStatus::AVAILABLE,
            'publication_date' => $this->faker->date('Y/m/d'),
            'category_id' => rand(1, 10),
        ];
    }
}
