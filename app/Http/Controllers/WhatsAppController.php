<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Notification;
use App\Models\OTP;
use App\Models\Role;
use App\Models\User;
use App\Models\WhatsApp;
use App\Services\WhatsAppBotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{

    public function sendMessage(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'message' => 'required'
        ]);

        $response = Http::withToken(env('WHATSAPP_BOT_TOKEN'))
            ->post('http://localhost:3000/api/send-message', [
                'phone_number' => $request->phone_number,
                'message' => "Kode OTP Anda adalah: {23764897293}"
            ]);

        return response()->json([
            'status' => 'success',
            'result' => $response
        ]);
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

        $formattedPhoneNumber = preg_replace('/^0/', '62', $request->phone_number) . '@c.us';

        $response = Http::withToken(env('WHATSAPP_BOT_TOKEN'))
            ->post('http://localhost:3000/api/send-message', [
                'phone_number' => $formattedPhoneNumber,
                'message' => $notification->message
            ]);

        return response()->json([
            'status' => 'success',
            'result' => $notification
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Perpanjangan peminjaman berhasil dikonfirmasi.',
            'borrow' => $borrow
        ]);
    }

    public function checkUserExists(Request $request)
    {
        $phone = $request->query('phone');

        $exists = User::where('phone_number', $phone)->exists();

        return response()->json(['exists' => $exists]);
    }
}
