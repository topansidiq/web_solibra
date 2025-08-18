<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::all();
        $categories = Category::withCount('books')->get();
        $borrows = Borrow::all();
        $users = User::all();

        $user = Auth::user();

        $books_count = Book::count();
        $categories_count = Category::count();
        $borrows_count = Borrow::count();
        $users_count = User::count();
        $selectedCategories = $request->input("categories", []);
        $categoriesQuuery = Category::query();

        if (!empty($selectedCategories)) {
            $categoriesQuuery->whereHas("categories", function ($query) use ($selectedCategories) {
                $query->whereIn("id", $selectedCategories);
            });
        }

        // Data peminjaman per bulan
        $borrowsPerMonth = Borrow::select(
                DB::raw('MONTH(borrowed_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('borrowed_at', Carbon::now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        // Data overdue per bulan
        $overduePerMonth = Borrow::select(
                DB::raw('MONTH(borrowed_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('status', 'overdue')
            ->whereYear('borrowed_at', Carbon::now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $months = collect(range(1, 12))->map(function ($m) {
            return Carbon::create()->month($m)->locale('id')->translatedFormat('F');
        });

        $borrowData = $months->keys()->map(function ($i) use ($borrowsPerMonth) {
            return $borrowsPerMonth[$i+1] ?? 0;
        });

        $overdueData = $months->keys()->map(function ($i) use ($overduePerMonth) {
            return $overduePerMonth[$i+1] ?? 0;
        });

        return view("admin.dashboard.index", compact("users", "borrows", "books", "categories",  "books_count", "categories_count", "borrows_count", "users_count", "selectedCategories", "user","months","borrowData", "overdueData"
        ));
    }
}
