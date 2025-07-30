<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    protected $borrows = [
        'max' => 3,
        'expired' => null,
        'length' => 0
    ];

    public function index(Request $request)
    {
        $sortBy = $request->get("sort_by", 'borrowed_at');
        $sortDir = $request->get('sort_dir', 'desc');

        $borrows = Borrow::with(['book', 'user'])
            ->orderBy($sortBy, $sortDir)
            ->paginate(20)
            ->appends($request->all());

        $categories = Category::withCount('books')
            ->orderBy('name', 'asc')
            ->get();
        $books = Book::with(['categories'])
            ->orderBy('title', 'asc')
            ->get();

        $users = User::all();

        return view("admin.borrows.index", compact("borrows", "sortBy", "sortDir", "categories", "books", "users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function confirm(Borrow $borrow)
    {
        $now = now();

        $borrow->update([
            'status' => 'confirmed',
            'borrowed_at' => $now,
        ]);

        $book = $borrow->book;
        $book->decrement('stock');

        return back()->with('success', 'Peminjaman berhasil dikonfirmasi.');
    }

    public function return(Borrow $borrow)
    {
        $borrow->update(['status' => 'returned', 'return_date' => now()]);
        $book = $borrow->book;
        $book->increment('stock');
        return back()->with('success', 'Peminjaman selesai.');
    }

    public function overdue(Borrow $borrow)
    {
        $borrow->update(['status' => 'returned']);
        return back()->with('success', 'Peminjaman melewati batas pengembalian.');
    }

    public function archive(Borrow $borrow)
    {
        $borrow->update(['status' => 'archive']);
        return back()->with('success', 'Peminjaman berhasil diarsipkan.');
    }

    public function store(Request $request)
    {
        // $book = Book::find($request->book_id);
        // if ($book->stock <= 0) {
        //     return redirect()->back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        // }

        // $user_borrowed = Borrow::where('user_id');
        // $borrows['length'] = $user_borrowed->count();

        // $validated = $request->validate([
        //     'book_id' => 'required|exists:books,id',
        //     'user_id' => 'required|exists:users,id',
        //     'borrowed_at' => 'required|date',
        // ]);

        // $borrowedAt = Carbon::parse($validated['borrowed_at']);


        // $borrow = Borrow::create([
        //     'book_id' => $validated['book_id'],
        //     'user_id' => $validated['user_id'],
        //     'borrowed_at' => $borrowedAt,
        //     'due_date' => $borrowedAt->copy()->addDays(14),
        //     'status' => 'unconfirmed',
        // ]);

        // Notification::create([
        //     'user_id' => $borrow->user()->name,
        //     'type' => 'loan_request',
        //     'message' => "Peminjaman buku '{$book->title}' telah diajukan pada '{$borrow->borrowed_at}'.",
        // ]);

        // return redirect()->route('borrows.index')->with('success', 'Peminjaman berhasil dibuat!');



        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'borrowed_at' => 'required|date',
        ]);

        $userId = $validated['user_id'];
        $book = Book::findOrFail($validated['book_id']);

        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        // Ambil semua peminjaman aktif (belum dikembalikan)
        $activeBorrows = Borrow::where('user_id', $userId)
            ->whereNull('return_date')
            ->get();

        // Update array borrows
        $this->borrows['length'] = $activeBorrows->count();

        $this->borrows['expired'] = $activeBorrows->contains(function ($borrow) {
            return now()->gt(Carbon::parse($borrow->due_date));
        });

        if ($this->borrows['expired']) {
            return redirect()->back()->with('error', 'Ada buku yang belum dikembalikan dan sudah jatuh tempo.');
        }

        if ($this->borrows['length'] >= $this->borrows['max']) {
            return redirect()->back()->with('error', 'Kamu telah mencapai batas maksimum peminjaman.');
        }

        // Lanjutkan membuat peminjaman
        $borrowedAt = Carbon::parse($validated['borrowed_at']);

        $borrow = Borrow::create([
            'book_id' => $validated['book_id'],
            'user_id' => $userId,
            'borrowed_at' => $borrowedAt,
            'due_date' => $borrowedAt->copy()->addDays(14),
            'status' => 'unconfirmed',
        ]);

        Notification::create([
            'user_id' => $userId,
            'type' => 'loan_request',
            'message' => "Peminjaman buku '{$book->title}' telah diajukan pada '{$borrow->borrowed_at}'.",
        ]);

        return redirect()->route('borrows.index')->with('success', 'Peminjaman berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrow $borrow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrow $borrow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrow $borrow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrow $borrow)
    {
        $borrow->delete();
        return redirect()->route('borrows.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
