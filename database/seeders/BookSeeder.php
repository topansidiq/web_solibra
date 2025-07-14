<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Buat 20 buku dan assign kategori random
        Book::factory(20)->create()->each(function ($book) {
            $book->categories()->attach(
                Category::query()->inRandomOrder()->limit(rand(1, 4))->pluck('id')->toArray()
            );
        });
    }
}