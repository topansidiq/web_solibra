<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyBotRequest
{

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if ($token !== env('WHATSAPP_BOT_TOKEN')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
