<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            // Mengambil semua kategori dengan jumlah buku yang terkait
            $categories = Category::withCount('books')->get();
            return view("admin.categories.index", compact("categories"));
        } catch (Throwable $th) {
            Log::error($th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'categories' => 'required|string',
            ]);

            $categoriesString = $request->input('categories');

            $categoriesArray = collect(explode(',', $categoriesString))
                ->map(fn($cat) => trim($cat))
                ->filter(fn($cat) => !empty($cat))
                ->unique();

            foreach ($categoriesArray as $categoryName) {
                Category::firstOrCreate([
                    'name' => $categoryName,
                ]);
            }
            return redirect()->back()->with('success', 'Kategori berhasil dibuat!');
        } catch (ValidationException $e) {
            Log::error('Validation Error when storing category: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }
}
