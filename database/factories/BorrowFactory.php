<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrow>
 */
class BorrowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'book_id' => Book::inRandomOrder()->value('id'),
            'borrowed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'return_date' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'due_date' => $this->faker->dateTimeBetween('+7 days', '+1 month'),
            'status' => $this->faker->randomElement(['unconfirmed', 'confirmed', 'returned', 'overdue']),
        ];
    }
}
