<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class BookController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $sortBy = $request->get("sort_by", 'title');
            $sortDir = $request->get('sort_dir', 'asc');
            $validSorts = ["id", "title", "author", "publisher", "year", "isbn", "stock"];
            $categoryId = $request->get('category');

            if (!in_array($sortBy, $validSorts)) {
                $sortBy = "title";
            }

            $booksQuery = Book::with(['categories', 'borrows.user']);
            if ($categoryId) {
                $booksQuery->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                });
            }

            $books = $booksQuery
                ->orderBy($sortBy, $sortDir)
                ->paginate(20)
                ->appends($request->all());

            $categories = Category::withCount('books')->get();

            return view("admin.books.index", compact("books", "categories", "sortBy", "sortDir", "user"));
        } catch (Exception $e) {
            // Logging error (opsional)
            Log::error("Error fetching books: " . $e->getMessage());

            // Redirect ke halaman error atau kembali dengan pesan
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data buku.');
        }
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'nullable|string',
            'language' => 'nullable|string',
            'pages' => 'nullable|integer|min:0',
            'year' => 'nullable|integer',
            'isbn' => 'nullable|string|unique:books,isbn',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
            'supply_date' => 'nullable|date',
            'identification_number' => 'nullable|string',
            'material' => 'nullable|string',
            'physical_shape' => 'nullable|string',
            'edition' => 'nullable|string',
            'publication_place' => 'nullable|string',
            'physical_description' => 'nullable|string',
            'acquisition_source' => 'nullable|string',
            'acquisition_name' => 'nullable|string',
            'price' => 'nullable|string',
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $book = Book::create($validated);

        if ($request->has('categories')) {
            $book->categories()->sync($request->categories);
        }

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function update(Request $request, Book $book)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string',
                'author' => 'required|string',
                'publisher' => 'nullable|string',
                'language' => 'nullable|string',
                'pages' => 'nullable|integer|min:0',
                'year' => 'nullable|integer',
                'isbn' => 'nullable|string|unique:books,isbn',
                'categories' => 'nullable|array',
                'categories.*' => 'exists:categories,id',
                'stock' => 'nullable|integer|min:0',
                'description' => 'nullable|string',
                'cover' => 'nullable|image|max:2048',
                'supply_date' => 'nullable|date',
                'identification_number' => 'nullable|string',
                'material' => 'nullable|string',
                'physical_shape' => 'nullable|string',
                'edition' => 'nullable|string',
                'publication_place' => 'nullable|string',
                'physical_description' => 'nullable|string',
                'acquisition_source' => 'nullable|string',
                'acquisition_name' => 'nullable|string',
                'price' => 'nullable|string',
            ]);

            // Update buku
            $book->update($validated);

            // Sync kategori
            $book->categories()->sync($request->categories ?? []);

            return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
        } catch (Throwable $e) {
            // Log error untuk debugging
            Log::error('Gagal update buku', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui buku.',
                'error' => $e->getMessage(), // Bisa dihapus di production
            ], 500);
        }
    }


    public function edit(Book $book)
    {
        $book = Book::findOrFail($book->id);
        $categories = Category::all();
        return view('admin.books.edit', compact('book', "categories"));
    }

    public function destroy(Book $book)
    {
        // Hapus cover jika ada
        if ($book->cover && Storage::exists('public/cover/' . $book->cover)) {
            Storage::delete('public/cover/' . $book->cover);
        }

        // Detach kategori
        $book->categories()->detach();

        // Hapus buku
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
