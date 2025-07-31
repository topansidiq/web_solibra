<?php

namespace App\Http\Controllers;

use App\Jobs\SendOtpDelayed;
use App\Models\OTP;
use App\Models\User;
use App\Services\WhatsAppBotService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleAction(Request $request, WhatsAppBotService $wa)
    {
        $request->validate([
            'from' => 'required|string',
            'action' => 'required|string',
        ]);

        $user = User::where('phone_number', $request->from)->first();

        if (!$user) {
            return response()->json(['message' => 'Nomor tidak terdaftar'], 404);
        }

        if ($request->action === 'request_otp') {
            $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            OTP::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'otp' => $otpCode,
                    'expired_at' => now()->addMinutes(5),
                ]
            );

            $wa->sendMessage($user->phone_number, "Permintaan OTP telah diterima, harap menunggu beberapa saat...");
            SendOtpDelayed::dispatch($user, $otpCode)->delay(now()->addSeconds(30));

            return response()->json(['message' => 'OTP dikirim']);
        }

        if (str_starts_with($request->action, 'verify_otp:')) {
            $enteredOtp = explode(':', $request->action)[1];

            $otp = OTP::where('user_id', $user->id)
                ->where('otp', $enteredOtp)
                ->where('expired_at', '>=', now())
                ->first();

            if ($otp) {
                $user->update(['is_phone_verified' => true]);
                return response()->json(['message' => 'OTP valid, nomor terverifikasi']);
            } else {
                return response()->json(['message' => 'OTP tidak valid atau sudah kedaluwarsa'], 422);
            }
        }

        return response()->json(['message' => 'Aksi tidak dikenal'], 400);
    }
}