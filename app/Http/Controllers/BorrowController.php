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
use Illuminate\Support\Facades\Http;

class BorrowController extends Controller
{
    protected $borrows = [
        'max' => 3,
        'extend' => 3,
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

        $book = $borrow->book;

        if ($book->stock <= 0) {
            return back()->with('error', 'Stok buku sudah habis. Tidak bisa dikonfirmasi.');
        }

        $borrowsCount = Borrow::where('user_id', $borrow->user_id)->where('status', 'confirmed')->count();

        if ($borrowsCount >= $this->borrows['max']) {
            return redirect()->back()->with('error', 'Peminjaman telah mencapai maksimal ' . $this->borrows['max']);
        }

        $borrowsOverdue = Borrow::where('user_id', $borrow->user_id)->where('due_date', '<', now())->whereIn('status', ['confirmed', 'overdue'])->whereRaw('due_date > DATE_ADD(borrowed_at, INTERVAL 42 DAY)')->exists();

        if ($borrowsOverdue) {
            return redirect()->back()->with('error', 'Ada buku yang belum dikembalikan dan sudah jatuh tempo.');
        }

        $borrow->update([
            'status' => 'confirmed',
            'borrowed_at' => $borrow->borrowed_at,
            'due_date' => now()->copy()->addDays(14),
        ]);

        Notification::create([
            'user_id' => $borrow->user_id,
            'type' => 'borrow_confirmed',
            'message' => "Peminjaman untuk buku yang berjudul '{$book->title}' pada {$borrow->borrowed_at} telah di konfirmasi oleh admin. Tanggal jatuh tempo atau pengembalian adalah pada {$borrow->due_date}.",
        ]);

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
        $borrow->update([
            'status' => 'returned',
            'return_date' => now()
        ]);
        return back()->with('success', 'Berhasil konfirmasi pengembalian.');
    }

    public function archive(Borrow $borrow)
    {
        $borrow->update(['status' => 'archive']);
        return back()->with('success', 'Peminjaman berhasil diarsipkan.');
    }

    public function extend(Borrow $borrow)
    {
        $book = $borrow->book;

        if ($borrow->extend >= 3) {
            return back()->with('error', 'Telah mencapai batas maksimal (3) kali perpanjangan buku.');
        }

        $borrowsOverdue = Borrow::where('user_id', $borrow->user_id)->where('due_date', '<', now())->whereIn('status', ['confirmed', 'overdue'])->whereRaw('due_date > DATE_ADD(borrowed_at, INTERVAL 42 DAY)')->exists();

        if ($borrowsOverdue) {
            return redirect()->back()->with('error', 'Ada buku yang belum dikembalikan dan sudah jatuh tempo.');
        }

        $borrow->increment('extend');
        $borrow->update([
            'status' => 'extend',
            'borrowed_at' => $borrow->borrowed_at,
            'due_date' => now()->copy()->addDays(14),
        ]);

        $message = "Perpanjangan peminjaman untuk buku yang berjudul '{$book->title}' pada {$borrow->borrowed_at} telah di konfirmasi oleh admin. Tanggal jatuh tempo atau pengembalian adalah pada {$borrow->due_date}.";

        Notification::create([
            'user_id' => $borrow->user_id,
            'type' => 'extend_confirmed',
            'message' => $message,
        ]);

        $response = Http::withToken(env('WHATSAPP_BOT_TOKEN'))
            ->post('http://localhost:3000/api/send-message', [
                'phone_number' => $borrow->user->phone_number,
                'message' => $message
            ]);

        return back()->with('success', 'Perpanjangan peminjaman berhasil dikonfirmasi.')->with('response', $response->json());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        $borrowsCount = Borrow::where('user_id', $validated['user_id'])->where('status', 'confirmed')->count();

        if ($borrowsCount >= $this->borrows['max']) {
            return redirect()->back()->with('error', 'Peminjaman telah mencapai maksimal ' . $this->borrows['max']);
        }

        $borrowsOverdue = Borrow::where('user_id', $validated['user_id'])->where('status', 'overdue')->exists();

        if ($borrowsOverdue) {
            return redirect()->back()->with('error', 'Ada buku yang belum dikembalikan dan sudah jatuh tempo.');
        }

        $borrow = Borrow::create([
            'book_id' => $validated['book_id'],
            'user_id' => $validated['user_id'],
            'borrowed_at' => now(),
            'due_date' => now()->addDays(42),
            'status' => 'unconfirmed',
        ]);

        if (Auth::user()->role == 'member') {
            Notification::create([
                'user_id' => $validated['user_id'],
                'type' => 'loan_request',
                'message' => "Anda telah mengajukan peminjaman untuk buku yang berjudul '{$book->title}' pada {$borrow->borrowed_at}. Silahkan menunggu konfirmasi dari admin.",
            ]);
        } elseif (Auth::user()->role == 'admin' || Auth::user()->role == 'librarian') {
            Notification::create([
                'user_id' => $validated['user_id'],
                'type' => 'loan_request',
                'message' => "Peminjaman buku '{$book->title}' telah diajukan pada '{$borrow->borrowed_at} oleh {$borrow->user_id}'.",
            ]);
        }

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
