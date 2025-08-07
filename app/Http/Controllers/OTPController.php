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
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use function PHPSTORM_META\type;

class OTPController extends Controller
{
    protected $whatsapp;

    public function __construct(WhatsAppBotService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }
    public function get(Request $request)
    {

        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'phone_number' => 'required|numeric'
            ]);
        } catch (ValidationException $e) {
            // Debug detail error validasi
            Log::error('VALIDATION ERROR:', $e->errors());
            return response()->json([
                'status' => 'VALIDATION_ERROR',
                'errors' => $e->errors()
            ], 422);
        }

        // DEBUG log
        Log::info('REQUEST LARAVEL MASUK:', $request->all());

        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        OTP::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'phone_number' => $request->phone_number,
            ],
            [
                'code' => $otp,
                'expires_at' => $expiresAt,
            ]
        );

        $message = "Kode OTP kamu adalah *$otp*. Berlaku selama 5 menit.";

        Notification::create([
            'user_id' => $request->user_id,
            'message' => $message,
            'type' => 'whatsapp_verification',
            'is_read' => false
        ]);

        return response()->json(['otp' => $otp, 'message' => $message]);
        //     $request->validate([
        //         'user_id' => 'required|exists:users,id',
        //         'phone_number' => 'required|numeric'
        //     ]);

        //     $otp = rand(100000, 999999);
        //     $expiresAt = now()->addMinutes(5);

        //     OTP::updateOrCreate(
        //         [
        //             'user_id' => $request->user_id,
        //             'phone_number' => $request->phone_number,
        //         ],
        //         [
        //             'code' => $otp,
        //             'expires_at' => $expiresAt,
        //         ]
        //     );

        //     $message = "Kode OTP kamu adalah *$otp*. Berlaku selama 5 menit.";

        //     Notification::create([
        //         'user_id' => $request->user_id,
        //         'message' => $message,
        //         'type' => 'whatsapp_verification',
        //         'is_read' => false
        //     ]);

        //     Log::info('Request OTP masuk:', $request->all());

        //     return response()->json(['otp' => $otp, 'message' => $message]);
    }



    public function verifyOtp()
    {
        return view('member.account.verifyOTP');
    }
    public function verify(Request $request)
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
