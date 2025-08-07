<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $casts = [
        'year' => 'integer',
        'stock' => 'integer',
    ];

    protected $fillable = [
        'supply_date',
        'identification_number',
        'material',
        'physical_shape',
        'title',
        'author',
        'edition',
        'publication_place',
        'publisher',
        'year',
        'physical_description',
        'acquisition_source',
        'acquisition_name',
        'isbn',
        'price',
        'language',
        'stock',
        'description',
        'cover',
    ];

    public function getCleanTitleAttribute(): string
    {
        if (!$this->title) {
            return '-';
        }

        // Ambil bagian sebelum tanda /
        $title = explode('/', $this->title)[0];

        // Hapus spasi ekstra dan batasi panjang judul (opsional)
        return trim($title);
    }

    public function getFormattedAuthorAttribute()
    {
        if (!$this->author) {
            return '-';
        }

        // Pisah penulis berdasarkan ; atau , dan trim spasi
        $authors = preg_split('/[;,]/', $this->author);
        $authors = array_map('trim', $authors);

        // Jika panjang total lebih dari 20 karakter, cukup tampilkan satu penulis pertama
        $joined = implode(', ', $authors);
        if (strlen($joined) > 20) {
            return $authors[0];
        }

        // Jika panjang <= 20 karakter, tampilkan maksimal 2 penulis
        return implode(', ', array_slice($authors, 0, 2));
    }

    public function getInitialAttribute()
    {
        return strtoupper(substr($this->title, 0, 1));
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
