<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
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
        $user = Auth::user();
        return view("member.home.index", compact('user'));
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
        // contoh
        $user = User::with(['borrows.book'])
            ->where('phone_number', $request->phone_number)
            ->first();


        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan']);
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

        /** @var User $user */
        $user = Auth::user();
        $books = Book::all();
        $latestBook = Book::latest()->take(6)->get();
        $categories = Category::whereHas('books')->take(5)->get();
        $collections = $user->borrows()
            ->where('status', 'confirmed')
            ->with('book')
            ->get();
        $selectedCategory = $request->query('category');
        $books = Book::when($selectedCategory, function ($query, $categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        })->latest()->take(6)->get();

        return view('member.collection.index', compact('latestBook', 'books', 'categories', 'selectedCategory', 'collections', 'user'));
    }

    public function borrow()
    {
        /** @var User $user */
        $user = Auth::user();

        $borrows = $user->borrows();
        return view('member.borrow.index', compact('borrows', 'user'));
    }

    public function information(Request $request)
    {
        $user = Auth::user();

        $informations = Information::orderBy('created_at', 'desc')->get();

        return view('member.information.index', compact('informations', 'user'));
    }

     public function show(Information $information)
    {
        $user = Auth::user();
        return view('member.information.show', compact('information', 'user'));
    }

    public function storeBorrow(Request $request, Book $book)
    {

        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'due_date' => 'required|date|after:today',
        ]);

        $borrow = Borrow::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => $request->due_date,
            'status' => 'unconfirmed',
        ]);

        $recipients = User::whereIn('role', [
            Role::Admin->value,
            Role::Librarian->value
        ])->get();


        foreach ($recipients as $recipient) {
            Notification::create([
                'user_id' => $recipient->id,
                'type' => 'loan_request',
                'message' => "📥 Pengajuan peminjaman buku '{$book->title}' oleh {$user->name} pada '{$borrow->borrowed_at}'.",
            ]);
        }

        Notification::create([
            'user_id' => $user->id,
            'type' => 'loan_request',
            'message' => "Anda telah mengajukan peminjaman buku '{$book->title}' pada '{$borrow->borrowed_at}'.",
        ]);

        $message = "📚 Hai {$user->name},\n\n" .
            "Pengajuan peminjaman buku *{$book->title}* kamu telah dikirim ke petugas perpustakaan. " .
            "Mohon tunggu konfirmasi selanjutnya.\n\n" .
            "📅 Jatuh tempo: " . \Carbon\Carbon::parse($request->due_date)->format('d M Y') . "\n\n" .
            "Terima kasih 🙏";

        app(WhatsAppBotService::class)->sendMessage($user->phone_number, $message);
        WhatsApp::create([
            'user_id' => $user->id,
            'phone_number' => $user->phone_number,
            'message' => $message,
            'direction' => 'sent',
            'processed' => false
        ]);

        return redirect()->route('member.borrow')->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }
}
