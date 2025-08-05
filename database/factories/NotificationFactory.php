<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // akan membuat user baru jika tidak ada
            'type' => $this->faker->randomElement(['info', 'warning', 'alert']),
            'message' => $this->faker->sentence(),
            'is_read' => $this->faker->boolean(30), // 30% kemungkinan sudah dibaca
        ];
    }
}
