<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppBotService
{

    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.whatsapp_bot.base_url');
        $this->token = config('services.whatsapp_bot.token');
    }

    public function sendMessage($phone_number, $message)
    {

        $phone_number = preg_replace('/^0/', '62', $phone_number);

        return Http::withToken($this->token)->post($this->baseUrl . '/api/send-message', [
            'phone_number' => $phone_number,
            'message' => $message,
        ]);
    }
}