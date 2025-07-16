<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        return view("member.home.index", compact('user'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('member.profile.index', compact('user'));
    }

    public function collection(Request $request)
    {

        /** @var User $user */
        $user = Auth::user();
        $books = Book::all();
        $latestBook = Book::latest()->take(6)->get();
        $categories = Category::whereHas('books')->take(5)->get();
        $collections = $user->borrows()
            ->where('status', 'confirmed')
            ->with('book')
            ->get();
        $selectedCategory = $request->query('category');
        $books = Book::when($selectedCategory, function ($query, $categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        })->latest()->take(6)->get();

        return view('member.collection.index', compact('latestBook', 'books', 'categories', 'selectedCategory', 'collections', 'user'));
    }

    public function borrow()
    {
        /** @var User $user */
        $user = Auth::user();

        $borrows = $user->borrows();
        return view('member.borrow.index', compact('borrows', 'user'));
    }

    public function storeBorrow(Request $request, Book $book)
    {

        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'due_date' => 'required|date|after:today',
        ]);

        Borrow::create([
            'user_id' => $user->id(),
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => $request->due_date,
            'status' => 'unconfirmed',
        ]);

        return redirect()->route('member.borrow')->with('success', 'Permintaan peminjaman berhasil dikirim.');
    }
}
