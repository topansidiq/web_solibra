<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\WhatsAppBotService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function showResetPasswordForm(Request $request, $token = null)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'phone_number' => $request->phone_number,
        ]);
    }

    public function sendResetPasswordLink(Request $request, WhatsAppBotService $bot)
    {
        try {
            $request->validate([
                'phone_number' => 'required'
            ]);

            $user = User::where('phone_number', $request->phone_number)->first();

            // Buat token reset
            $token = generateNumericOTP(8);

            // Kirim lewat WhatsApp
            $resetUrl = url(route('password.reset', ['token' => $token, 'phone_number' => $user->phone_number], false));
            $status = $bot->sendMessage(formattedPhoneNumberToUs62($user->phone_number), "Klik link ini untuk reset password:\n\n> {$resetUrl}");

            return redirect()->back()->with('success', 'Berhasil mengirimkan link reset password ke WhatsApp anda!');
        } catch (ValidationException $e) {
            Log::error('VALIDATION ERROR:', $e->errors());
            return response()->json([
                'status' => 'VALIDATION_ERROR',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            Log::error("Gagal kirim WA reset password", ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Gagal mengirim link reset via WhatsApp'], 500);
        }
    }
}
