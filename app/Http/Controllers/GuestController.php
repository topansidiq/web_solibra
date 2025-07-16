<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function home()
    {
        $latestBook = Book::latest()->take(6)->get();

        return view('welcome', compact('latestBook'));
    }

    public function collection(Request $request)
    {
        $latestBook = Book::latest()->take(6)->get();
        $books = Book::all();

        $categories = Category::whereHas('books')->take(5)->get();
        $selectedCategory = $request->query('category');
        $books = Book::when($selectedCategory, function ($query, $categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        })->latest()->take(6)->get();

        return view('collection', compact('latestBook', 'books', 'categories', 'selectedCategory'));
    }
}
