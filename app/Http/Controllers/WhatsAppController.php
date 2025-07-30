<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\OTP;
use App\Models\Role;
use App\Models\WhatsApp;
use App\Services\WhatsAppBotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WhatsAppController extends Controller
{
    public function sendOTP(Request $request, WhatsAppBotService $bot, OTP $otp)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'phone_number' => 'required|exists:users,phone_number',
                'message' => 'required|string|max:255',
                'direction' => 'required|string|in:send,received',
                'processed' => 'sometimes|bolean'
            ]);

            $phoneNumber = $request->phone_number;
            $formattedPhoneNumber = preg_replace('/^0/', '62', $phoneNumber) . '@c.us';

            $whatsapp = WhatsApp::create([
                'user_id' => $request->user_id,
                'phone_number' => $formattedPhoneNumber,
                'message' => $request->message,
                'direction' => 'send',
                'processed' => 'false'
            ]);

            $bot->sendMessage($whatsapp->phone_number, $whatsapp->message);
            Notification::create([
                'user_id' => $whatsapp->user_id,
                'type' => 'otp_send',
                'message' => $whatsapp->message
            ]);

            $user = Auth::user();

            if ($user->role == Role::Admin->value || $user->role == Role::Admin->value) {
                return redirect()->route('users.index')->with('success', 'OTP telah dikirim!');
            } else {
                return redirect()->route('member.account')->with('success', 'OTP telah dikirimkan melalui WhatsApp anda, harap segera verifikasi sebelum 10 menit, dan jangan bagikan kode OTP ke siapapun!');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
