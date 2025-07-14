<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    /** @use HasFactory<\Database\Factories\BorrowFactory> */
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'borrowed_at',
        'due_date',
        'return_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function categories()
    {
        return $this->hasManyThrough(
            Category::class,     // Target akhir
            Book::class,         // Model perantara
            'id',                // foreignKey di Book (untuk Borrow)
            'id',                // foreignKey di Category (untuk Book)
            'book_id',           // foreignKey di Borrow
            'id'                 // localKey di Book
        );
    }
}
