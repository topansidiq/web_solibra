<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\OTP;
use App\Models\User;
use App\Models\WhatsApp;
use App\Services\WhatsAppBotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use function PHPSTORM_META\type;

class OTPController extends Controller
{
    protected $whatsapp;

    public function __construct(WhatsAppBotService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }
    public function sendOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'phone_number' => 'required|numeric'
        ]);

        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        OTP::updateOrCreate([
            'user_id' => $request->user_id,
            'code' => $otp,
            'expires_at' => $expiresAt,
            'verified' => false
        ]);

        $message = "Kode OTP kamu adalah *$otp*. Berlaku selama 5 menit.";
        // $this->whatsapp->sendMessage($request->phone_number, $message);

        Notification::create([
            'user_id' => $request->user_id,
            'message' => $message,
            'type' => 'whatsapp_verification',
            'is_read' => false
        ]);

        // dd($message, $otp);

        return redirect()->back()
            ->with('otp_sent', true)
            ->with('phone_number', $request->phone_number)
            ->with('success', true)
            ->with('message', 'OTP berhasil dikirim ke WhatsApp Anda.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric',
            'code' => 'required|digits:6'
        ]);

        $otp = OTP::where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return response()->json(['message' => 'OTP tidak valid atau kadaluarsa'], 422);
        }

        $otp->update(['verified' => true]);

        User::where('phone_number', $request->phone_number)
            ->update(['is_phone_verified' => true]);

        if (!$otp) {
            return redirect()->back()
                ->with('otp_sent', true)
                ->with('phone_number', $request->phone_number)
                ->with('success', false)
                ->with('message', 'OTP tidak valid atau sudah kadaluarsa.');
        }

        // Jika berhasil
        return redirect()->route('dashboard')
            ->with('success', true)
            ->with('message', 'Verifikasi berhasil.');
    }
}
