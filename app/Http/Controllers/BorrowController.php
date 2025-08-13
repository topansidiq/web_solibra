<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\Notification;
use App\Models\User;
use App\Services\WhatsAppBotService;
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

    protected $bot;

    public function __construct(WhatsAppBotService $bot)
    {
        $this->bot = $bot;
    }

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

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $borrowsCount = Borrow::where('user_id', $request->user_id)->where('status', 'confirmed')->count();
        $borrowsOverdue = Borrow::where('user_id', $request->user_id)->where('status', 'overdue')->exists();

        if ($user->member_status !== 'validated') {
            return redirect()->back()->with('error', 'Tidak dapat melakukan peminjaman karena anggota ini belum tervalidasi!');
        }

        if ($borrowsOverdue) {
            return redirect()->back()->with('error', 'Ada buku yang belum dikembalikan dan sudah jatuh tempo.');
        }

        if ($borrowsCount >= $this->borrows['max']) {
            return redirect()->back()->with('error', 'Peminjaman telah mencapai maksimal ' . $this->borrows['max']);
        }

        $borrow = Borrow::create([
            'book_id' => $request->book_id,
            'user_id' => $request->user_id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(42),
        ]);

        if ($user->role == 'member') {
            $message = "Peminjaman anda untuk {$borrow->book->physical_shape} {$borrow->book->title} telah berhasil di tambahkan. Silahkan mengambil buku dan konfirmasi ke Admin.";

            Notification::create([
                'user_id' => $request->user_id,
                'type' => 'loan_request',
                'message' => $message,
            ]);

            try {
                $this->bot->sendMessage(formattedPhoneNumberToUs62($user->phone_number), $message);
            } catch (\Throwable $th) {
                throw $th;
            }
        } elseif (Auth::user()->role == 'admin' || Auth::user()->role == 'librarian') {
            Notification::create([
                'user_id' => $request->user_id,
                'type' => 'loan_request',
                'message' => "Peminjaman buku baru telah berhasil dibuat untuk {$borrow->book->physical_shape} {$borrow->book->title} pada {$borrow->borrowed_at}'.",
            ]);
        }

        return redirect()->route('borrows.index')->with('success', 'Peminjaman berhasil dibuat!');
    }

    public function confirm(Borrow $borrow)
    {

        $book = $borrow->book;

        if ($borrow->user->member_status !== 'validated') {

            try {
                $message = 'Permohonan peminjaman anda ditolak karena data anda belum tervalidasi sebagai anggota di Perpustakaan Umum Kota Solok. Silahkan mendatangi perpustaakan untuk melakukan validasi data. Terima kasih';

                Notification::create([
                    'user_id' => $borrow->user_id,
                    'type' => 'borrow_rejected',
                    'message' => $message,
                ]);

                $this->bot->sendMessage(formattedPhoneNumberToUs62($borrow->user->phone_number), "> Layanan Chatbot Perpustakaan Umum Kota Solok\n\n{$message}");
            } catch (\Throwable $th) {
                throw $th;
            }

            return back()->with('error', 'Anggota ini belum melakukan validasi data secara fisik ke Perpustakaan Umum Kota Solok.');
        }

        if ($book->stock <= 0) {
            return back()->with('error', 'Stok buku sudah habis. Tidak bisa dikonfirmasi.');
        }

        $borrowsCount = Borrow::where('user_id', $borrow->user_id)->whereIn('status', ['confirmed', 'overdue'])->count();

        if ($borrowsCount >= $this->borrows['max']) {
            return back()->with('error', 'Peminjaman telah mencapai maksimal ' . $this->borrows['max']);
        }

        $borrowsOverdue = Borrow::where('user_id', $borrow->user_id)->where('due_date', '<', now())->whereIn('status', ['confirmed', 'overdue'])->whereRaw('due_date > DATE_ADD(borrowed_at, INTERVAL 42 DAY)')->exists();

        if ($borrowsOverdue) {
            return back()->with('error', 'Ada buku yang belum dikembalikan dan sudah jatuh tempo.');
        }

        $borrow->update([
            'status' => 'confirmed',
            'borrowed_at' => $borrow->borrowed_at,
            'due_date' => now()->copy()->addDays(14),
        ]);

        Notification::create([
            'user_id' => $borrow->user_id,
            'type' => 'borrow_confirmed',
            'message' => "Peminjaman untuk buku yang berjudul {$book->title} pada {$borrow->borrowed_at} telah di konfirmasi oleh admin. Tanggal jatuh tempo atau pengembalian adalah pada {$borrow->due_date}.",
        ]);

        $book->decrement('stock');

        return back()->with('success', 'Peminjaman berhasil dikonfirmasi.');
    }

    public function return(Borrow $borrow)
    {
        $borrow->update(['status' => 'returned', 'return_date' => now()]);
        $book = $borrow->book;
        $book->increment('stock');

        $message = "Peminjaman untuk {$book->physical_shape} {$book->title} telah selesai dan pengembalian telah berhasil di konfirmasi.";

        Notification::create([
            'user_id' => $borrow->user_id,
            'type' => 'return_confirmend',
            'message' => $message
        ]);

        try {
            $this->bot->sendMessage(formattedPhoneNumberToUs62($borrow->user->phone_number), "> Layanan Chatbot Perpustakaan Umum Kota Solok\n\n{$message}");
        } catch (\Throwable $th) {
            throw $th;
        }

        return back()->with('success', 'Peminjaman selesai.');
    }

    public function overdue(Borrow $borrow)
    {
        $borrow->update([
            'status' => 'returned',
            'return_date' => now()
        ]);

        $message = "Peminjaman untuk {$borrow->book->physical_shape} {$borrow->book->title} telah selesai dan pengembalian telah berhasil di konfirmasi.";

        Notification::create([
            'user_id' => $borrow->user_id,
            'type' => 'return_confirmend',
            'message' => $message
        ]);

        try {
            $this->bot->sendMessage(formattedPhoneNumberToUs62($borrow->user->phone_number), "> Layanan Chatbot Perpustakaan Umum Kota Solok\n\n{$message}");
        } catch (\Throwable $th) {
            throw $th;
        }

        return back()->with('success', 'Berhasil konfirmasi pengembalian.');
    }

    public function archive(Borrow $borrow)
    {
        $borrow->update(['status' => 'archive']);
        return back()->with('success', 'Peminjaman berhasil diarsipkan.');
    }

    public function extend(Borrow $borrow, WhatsAppBotService $bot)
    {
        $book = $borrow->book;

        if ($borrow->extend >= 3) {
            return back()->with('error', "Telah mencapai batas maksimal (3) kali perpanjangan buku.");
        }

        $borrowsOverdue = Borrow::where('user_id', $borrow->user_id)->where('due_date', '<', now())->whereIn('status', ['confirmed', 'overdue'])->whereRaw('due_date > DATE_ADD(borrowed_at, INTERVAL 42 DAY)')->exists();

        if ($borrowsOverdue) {
            return redirect()->back()->with('error', 'Ada buku yang belum dikembalikan dan sudah jatuh tempo.');
        }

        $borrow->increment('extend');
        $borrow->update([
            'status' => 'extend',
            'due_date' => now()->copy()->addDays(14),
        ]);

        $today = now()->format('d-m-Y');

        $message = "Perpanjangan peminjaman untuk {$book->physical_shape} {$book->title} pada {$today} telah di konfirmasi oleh admin. Tanggal jatuh tempo atau pengembalian adalah pada {$borrow->due_date}.";

        Notification::create([
            'user_id' => $borrow->user_id,
            'type' => 'extend_confirmed',
            'message' => $message,
        ]);

        try {
            $this->bot->sendMessage(formattedPhoneNumberToUs62($borrow->user->phone_number), "> Layanan Chatbot Perpustakaan Umum Kota Solok\n\n{$message}");
        } catch (\Throwable $th) {
            throw $th;
        }

        return back()->with('success', 'Perpanjangan peminjaman berhasil dikonfirmasi.');
    }

    public function show(Borrow $borrow)
    {
        $user = Auth::user();
        $borrows = Borrow::where('user_id', $borrow->user_id)->get();
        return view('admin.borrows.show', compact('borrow', 'user', 'borrows'));
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
