<?php

namespace App\Http\Controllers;

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

    public function checkUserExists(Request $request)
    {
        $phone = $request->query('phone');

        $exists = User::where('phone_number', $phone)->exists();

        return response()->json(['exists' => $exists]);
    }
}