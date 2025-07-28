<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CollectionController extends Controller
{
    public function index()
    {
        try {
            $collectins = Collection::all();
            Log::info('Koleksi berhasil dimuat!');
            return view('admin.collections.index', compact('collections'));
        } catch (\Throwable $th) {
            Log::error("Gagal memuat koleksi" . $th);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => "string|required|max:100|unique:collections,name",
                'description' => "nullable|string",
            ]);
            $collection = Collection::create($validated);

            Log::info('Koleksi baru baru ditambahkan', [
                'title' => $collection->name,
                'added_by' => Auth::user()?->id,
            ]);

            return redirect()->route('categories.index')->with('succes', 'Kategori "' . $collection->name . '" berhasil ditambahkan.');
        } catch (ValidationException $e) {

            // Tangani error validasi
            Log::error('Validation Error when storing collection: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {

            // Tangani error umum lainnya
            Log::error('Error storing collection: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan koleksi. Silakan coba lagi!')
                ->withInput();
        }
    }
}
