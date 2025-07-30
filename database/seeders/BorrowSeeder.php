<?php

namespace Database\Seeders;

use App\Models\Borrow;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BorrowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Borrow::factory(50)->create()->each(function ($borrow) {
            // Ambil buku yang dipinjam
            $book = $borrow->book;

            // Random kategori
            $categoryIds = Category::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();

            // Attach ke buku (bukan ke borrow!)
            $book->categories()->syncWithoutDetaching($categoryIds);
        });
    }
}
