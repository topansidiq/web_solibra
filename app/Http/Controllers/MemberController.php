<?php

namespace App\Http\Controllers;

use App\Models\Book;
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
        $books = Book::paginate(6);
        $collections = $user->borrows()
            ->where('status', 'confirmed')
            ->with('book')
            ->get();


        $categories = Category::paginate(6);
        $selectedCategory = $request->category;

        $bookSelect = Book::when($selectedCategory, function ($query) use ($selectedCategory) {
            $query->where('category_id', $selectedCategory);
        })->get();

        return view("member.collection.index", compact('collections', 'user', 'books', 'bookSelect', 'categories', 'selectedCategory'));
    }
}
