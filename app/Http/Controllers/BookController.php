<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Throwable;

class BookController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Book::query();

            if ($request->has('search') && $request->search !== '') {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%');
            }

            $user = Auth::user();
            $categoryId = $request->get('category');
            $page = (int) $request->get('page', 1);
            $perPage = 20;
            $offset = ($page - 1) * $perPage;

            // Filter kategori (jika ada)
            if ($categoryId) {
                $query->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                });
            }

            // Hitung total data untuk pagination
            $totalBooks = $query->count();

            // Ambil data sesuai halaman
            $books = $query
                ->skip($offset)
                ->take($perPage)->orderBy('title', 'asc')
                ->get();

            // Ambil semua kategori
            $categories = Category::withCount('books')->get();

            // Kirim ke view
            return view('admin.books.index', [
                'books' => $books,
                'categories' => $categories,
                'user' => $user,
                'currentPage' => $page,
                'perPage' => $perPage,
                'totalBooks' => $totalBooks
            ]);
        } catch (Exception $e) {
            Log::error("Error fetching books: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data koleksi.');
        }
    }

    public function create()
    {
        $categories = Category::withCount('books')->get();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string',
                'author' => 'required|string',
                'publisher' => 'nullable|string',
                'language' => 'nullable|string',
                'year' => 'nullable|integer|min:1000|max:' . date('Y'),
                'isbn' => 'nullable|string|unique:books,isbn',
                'categories' => 'nullable|array|min:1',
                'categories.*' => 'exists:categories,id',
                'stock' => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
                'cover' => 'nullable|image|max:2048',
                'supply_date' => 'nullable|string',
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

            if (!empty($validated['categories'])) {
                $book->categories()->sync($validated['categories']);
            }

            return redirect()->route('books.index')->with('success', 'Koleksi berhasil ditambahkan.');
        } catch (Throwable $e) {
            Log::error('Gagal menambahkan koleksi!', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan koleksi.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
                'isbn' => [
                    'nullable',
                    'string',
                    Rule::unique('books', 'isbn')->ignore($book->id),
                ],
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

            $book->update($validated);

            $book->categories()->sync($request->categories ?? []);

            return redirect()->route('books.index')->with('success', 'Koleksi berhasil diperbarui.');
        } catch (Throwable $e) {
            Log::error('Gagal memperbarui koleksi', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui koleksi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(Book $book)
    {
        $book = Book::findOrFail($book->id);
        $categories = Category::all();
        return view('admin.books.update', compact('book', "categories"));
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

        return redirect()->route('books.index')->with('success', 'Koleksi berhasil dihapus.');
    }
}
