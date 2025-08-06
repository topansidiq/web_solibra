<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->route('lang');

        // Pastikan hanya bahasa yang didukung yang dipakai
        if (!in_array($locale, ['en', 'id'])) {
            $locale = config('app.locale'); // fallback
        }

        App::setLocale($locale);

        return $next($request);
    }
}
