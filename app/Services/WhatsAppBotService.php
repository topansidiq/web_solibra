<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppBotService
{
    public function sendMessage(string $number, string $message): bool
    {
        $response = Http::withToken(env('WHATSAPP_BOT_TOKEN'))
            ->post(env('WHATSAPP_BOT_URL'), [
                'number' => $number,
                'message' => $message,
            ]);

        return $response->successful();
    }
}
