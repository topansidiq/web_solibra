<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggleFavorite(Book $book)
    {
        $user = Auth::user();

        if ($user->favoriteBooks->where('book_id', $book->id)->exists()) {
            $user->favoriteBooks->detach($book->id);
            return back()->with('success', 'Buku berhasil dihapus dari favorit');
        }

        $user->favoriteBooks->attach($book->id);

        return back()->with('success', 'Buku berhasil ditambahkan ke favorit');
    }

    public function myFavorites()
    {
        $favorites = Auth::user()->favoriteBooks->with('categories')->get();
        return view('favorites.index', compact('favorites'));
    }
}
