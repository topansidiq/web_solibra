<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;

class BorrowConfirmTest extends TestCase
{
    use RefreshDatabase;

    public function test_borrow_can_be_confirmed()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['stock' => 3]);

        $borrow = Borrow::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'pending',
        ]);

        $response = $this->post(route('borrows.confirm', $borrow), [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('borrows', [
            'id' => $borrow->id,
            'status' => 'confirmed',
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'stock' => 2,
        ]);
    }

    public function test_borrow_cannot_be_confirmed_if_stock_is_zero()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['stock' => 0]);

        $borrow = Borrow::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'pending',
        ]);

        $response = $this->post(route('borrows.confirm', $borrow), [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $response->assertSessionHas('error', 'Stok buku sudah habis. Tidak bisa dikonfirmasi.');
    }
}
