<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyBotRequest
{
    protected $except = [
        'otp/get'
    ];
    public function handle(Request $request, Closure $next)
    {
        // Validasi berdasarkan header rahasia (misal dari WhatsApp bot)
        $secret = $request->header('X-BOT-KEY');

        if ($secret !== env('WHATSAPP_BOT_TOKEN')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
