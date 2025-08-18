<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCollection
 */
class Collection extends Model
{
    /** @use HasFactory<\Database\Factories\CollectionFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function items()
    {
        return $this->morphedByMany(Book::class, 'collectible', 'collection_items');
        //         ->union(
        //             // $this->morphedByMany(Journal::class, 'collectible', 'collection_items')
        //         )->union(
        //             // $this->morphedByMany(Ebook::class, 'collectible', 'collection_items')
        //         );
    }

    // Atau jika ingin akses per jenis:
    public function books()
    {
        return $this->morphedByMany(Book::class, 'collectible', 'collection_items');
    }

    // public function journals()
    // {
    //     return $this->morphedByMany(Journal::class, 'collectible', 'collection_items');
    // }

    // public function ebooks()
    // {
    //     return $this->morphedByMany(Ebook::class, 'collectible', 'collection_items');
    // }
}
