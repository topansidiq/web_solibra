<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Notification;
use App\Models\OTP;
use App\Models\Role;
use App\Models\User;
use App\Models\WhatsApp;
use App\Notifications\ChatbotNotification;
use App\Services\WhatsAppBotService;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\TryCatch;

class WhatsAppController extends Controller
{

    protected $bot;

    public function __construct(WhatsAppBotService $bot)
    {
        $this->bot = $bot;
    }

    public function sendOTP(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'phone_number' => 'required',
        ]);

        $notification = Notification::where('user_id', $request->user_id)
            ->where('type', 'whatsapp_verification')
            ->latest()
            ->first();

        $this->bot->sendMessage(formattedPhoneNumberToUs62($request->phone_number), $notification->message);

        return response()->json([
            'status' => 'success',
            'result' => $notification
        ]);
    }

    public function extend(Borrow $borrow)
    {
        $book = $borrow->book;
        if ($borrow->extend >= 3) {
           $message = 'Telah mencapai batas maksimal (3) kali perpanjangan buku.';
           $this->bot->sendMessage(formattedPhoneNumberToUs62($borrow->user->phone_number), $message);
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
        $this->bot->sendMessage(formattedPhoneNumberToUs62($borrow->user->phone_number), $message);
        return response()->json([
            'success' => true,
            'message' => 'Perpanjangan peminjaman berhasil dikonfirmasi.',
            'borrow' => $borrow
        ]);
    }

    public function sendNotification(Request $request, WhatsAppBotService $bot)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'type' => 'required|string',
                'message' => 'required|string',
                'phone_number' => 'required|string',
            ]);
            $user = User::find($request->user_id);
            $user = User::find($request->user_id);
            if (!$user) {
                return response()->json([
                    'error' => 'User tidak ditemukan',
                ], 404);
            }
            $user->notify(new ChatbotNotification($request->message));
            $bot->sendMessage(formattedPhoneNumberToUs62($request->phone_number),  $request->message);
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengirimkan notifikasi ke Admin ' . $user->id,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAdmin()
    {
        try {
            $admin = User::where('role', 'admin')->first();
            if (!$admin) {
                return response()->json([
                    'error' => 'Admin tidak ditemukan',
                ], 404);
            }
            return response()->json(
                [
                    'id' => $admin->id,
                    'phone_number' => $admin->phone_number
                ]
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
