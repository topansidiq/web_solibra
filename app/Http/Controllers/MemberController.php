<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Information;
use App\Models\Notification;
use App\Models\OTP;
use App\Models\Role;
use App\Models\User;
use App\Models\WhatsApp;
use App\Services\WhatsAppBotService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;

class MemberController extends Controller
{
    public function dashboard()
    {
        $latestBook = Book::latest()->take(6)->get();
        $latestMedia = Gallery::latest()->take(6)->get();
        $latestEvent = Event::latest()->take(6)->get();
        $newItem = [
            'book' => Book::latest()->first(),
            'event' => Event::latest()->first(),
            'information' => Information::latest()->first(),
        ];
        $user = Auth::user();
        $borrows = Borrow::where('user_id', $user->id)->latest()->take(6)->get();
        return view("member.home.index", compact('user', 'latestBook', 'latestMedia', 'latestEvent', 'newItem', 'borrows'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('member.profile.index', compact('user'));
    }

    public function service()
    {
        $user = Auth::user();
        return view('member.service.index', compact('user'));
    }

    public function notification()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id)->get();
        return view('member.notification.index', compact('user', 'notifications'));
    }

    public function account()
    {
        $user = Auth::user();
        return view('member.account.index', compact('user'));
    }

    public function account_edit($id)
    {
        $user = User::findOrFail($id);
        return view('member.account.edit', compact("user"));
    }

    public function phoneNumberVerification()
    {
        try {
            $user = Auth::user();
            return view('member.account.phoneNumberVerification', compact('user'));
        } catch (Exception $e) {
            return error('Error' . $e);
        }
    }

    public function getUserByPhone(Request $request)
    {
        $user = User::with(['borrows.book'])
            ->where('phone_number', $request->phone_number)
            ->first();


        if (!$user) {
            return response()->json(['message' => 'Member tidak ditemukan']);
        }

        $borrows = Borrow::with('book')
            ->where('user_id', $user->id)
            ->orderBy('borrowed_at', 'asc')
            ->get();

        return response()->json(
            [
                'user_id' => $user->id,
                'name' => $user->name,
                'phone_number' => $user->phone_number,
                'member_status' => $user->member_status,
                'is_phone_verified' => $user->is_phone_verified,
                'borrows' => $borrows,
            ]
        );
    }

    public function collection(Request $request)
    {

        $user = Auth::user();

        $categories = Category::whereHas('books')->take(5)->get();

        $selectedCategory = $request->query('category');

        $books = Book::when($selectedCategory, function ($query, $categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        })
            ->latest()
            ->take(10)
            ->get();

        $collections = $user->borrows
            ->whereIn('status', ['confirmed', 'overdue'])
            ->with('book.categories')
            ->get()
            ->pluck('book');

        return view('member.collection.index', [
            'books' => $books,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'collections' => $collections,
            'user' => $user,
        ]);
    }

    public function showCollection($id)
    {
        $user = Auth::user();
        $book = Book::where('id', $id)->with('categories')->first();
        $categoryIds = $book->categories->pluck('id');

        $relatedBooks = Book::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        })
            ->where('id', '!=', $book->id)
            ->with('categories')
            ->latest()
            ->take(6)
            ->get();

        $isOverdue = Borrow::where('user_id', $user->id)
            ->where('status', 'overdue')
            ->exists();

        $maxBorrow = 3;
        $currentBorrowCount = Borrow::where('user_id', $user->id)
            ->whereIn('status', ['borrowed', 'pending'])
            ->count();

        $isMax = $currentBorrowCount >= $maxBorrow;

        return view('member.collection.show', compact('book', 'relatedBooks', 'user', 'isOverdue', 'isMax'));
    }

    public function borrow()
    {
        $user = Auth::user();
        $borrows = $user->borrows;

        $collections = $user->borrows
            ->whereIn('status', ['confirmed', 'overdue'])
            ->with('book.categories')
            ->get()
            ->pluck('book');

        return view('member.borrow.index', compact('borrows', 'user', 'collections'));
    }

    public function searchBooks(Request $request)
    {
        $q = $request->get('q');

        $books = Book::with('categories')
            ->where('title', 'like', "%{$q}%")
            ->orWhere('author', 'like', "%{$q}%")
            ->limit(20)
            ->get();

        return response()->json($books);
    }

    public function information(Request $request)
    {
        $user = Auth::user();

        $informations = Information::orderBy('created_at', 'desc')->get();

        return view('member.information.index', compact('informations', 'user'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $information = Information::findOrFail($id);
        return view('member.information.show', compact('information', 'user'));
    }

    public function storeBorrow(Request $request, WhatsAppBotService $bot)
    {
        // Validasi input form
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);


        $user = Auth::user();
        $isBorrow = Borrow::where('user_id', $user->id)->where('status', 'unconfirmed')->exists();

        if ($isBorrow) {
            return back()->with('error', 'Kamu telah mengajukan peminjaman untuk buku ini. Silahkan menunggu konfirmasi admin. Kamu dapat melihat daftar peminjaman anda di halaman peminjaman!')->with('duration', 10000);
        }

        $isOverdue = Borrow::where('user_id', $user->id)
            ->where('status', 'overdue')
            ->exists();

        if ($isOverdue) {
            return redirect()->back()->with('error', 'Tidak bisa meminjam karena kamu memiliki peminjaman yang sudah jatuh tempo.');
        }

        // Cek maksimal peminjaman
        $maxBorrow = 3;
        $currentBorrowCount = Borrow::where('user_id', $user->id)
            ->whereIn('status', ['borrowed', 'pending'])
            ->count();

        $isMax = $currentBorrowCount >= $maxBorrow;

        if ($isMax) {
            return redirect()->back()->with('error', 'Tidak bisa meminjam karena anda sudah mencapai batas maksimal (3) peminjaman.');
        }

        $due_date = now()->addDays(14);

        $borrow = Borrow::create([
            'user_id' => $user->id,
            'book_id' => $request->book_id,
            'borrowed_at' => now(),
            'due_date' => $due_date,
        ]);

        $recipients = User::whereIn('role', [
            Role::Admin->value,
            Role::Librarian->value
        ])->get();

        foreach ($recipients as $recipient) {
            Notification::create([
                'user_id' => $recipient->id,
                'type' => 'loan_request',
                'message' => "Pengajuan peminjaman buku '{$borrow->book->title}' oleh {$borrow->user->name} pada '{$borrow->borrowed_at}'.",
                'is_read' => false,
            ]);
        }

        // Notifikasi user
        $message = "> Layanan Chatbot Perpustakaan Umum Kota Solok\n\nHai {$borrow->user->name},pengajuan peminjaman buku *{$borrow->book->clean_title}* kamu telah dikirim ke petugas perpustakaan. Mohon tunggu konfirmasi selanjutnya. Terima kasih.";

        Notification::create([
            'user_id' => $user->id,
            'type' => 'loan_request',
            'message' => $message,
            'is_read' => false
        ]);

        $bot->sendMessage(formattedPhoneNumberToUs62($user->phone_number), $message);

        return redirect()->back()->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }
}
