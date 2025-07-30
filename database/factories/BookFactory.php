<?php

namespace Database\Factories;

use App\Models\Book;
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

    protected $model = Book::class;
    public function definition(): array
    {

        return [
            'supply_date' => $this->faker->date(),
            'identification_number' => $this->faker->unique()->regexify('[A-Z]{3}-[0-9]{4}'),
            'material' => $this->faker->randomElement(['Monograf', 'Multimedia']),
            'physical_shape' => $this->faker->randomElement(['Buku', 'Majalah', 'CD']),
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'edition' => $this->faker->randomElement(['Cet.1', 'Cetakan II', 'Revisi']),
            'publication_place' => $this->faker->city(),
            'publisher' => $this->faker->company(),
            'year' => $this->faker->year(),
            'physical_description' => $this->faker->sentence(),
            'acquisition_source' => $this->faker->randomElement(['Pembelian', 'Hibah', 'Donasi']),
            'acquisition_name' => $this->faker->company(),
            'isbn' => $this->faker->unique()->isbn13(),
            'price' => $this->faker->randomNumber(5),
            'language' => $this->faker->randomElement(['Indonesia', 'Inggris']),
            'stock' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->paragraph(),
            'cover' => null, // or use fake image path if needed
        ];
    }
}