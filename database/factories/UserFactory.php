<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $roleId = Role::whereIn('name', ['admin', 'librarian', 'member'])
            ->inRandomOrder()
            ->first()
            ->id;



        return [
            'name' => fake()->name(),
            'id_number' => $this->faker->unique()->numerify('2025########'),
            'gender' => $this->faker->randomElement(['female', 'male']),
            'place_birth' => $this->faker->streetName(),
            'birth_date' => $this->faker->date(),
            'last_education' => $this->faker->randomElement(['SD', 'SMA/SMK', 'SMP', 'S1', 'Diploma III', 'Diploma IV', 'S2', 'S3', 'Magister Terapan', 'Akademisi', 'Sertifikasi']),
            'job' => $this->faker->jobTitle(),
            'phone_number' => fake()->unique()->numerify('08#########'),
            'phone_number_verified' => $this->faker->randomElement(['verified', 'unverified']),
            'role_id' => $roleId,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
