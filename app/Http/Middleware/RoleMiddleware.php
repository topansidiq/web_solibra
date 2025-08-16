<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Konversi string role yang dikirim ke RoleEnum
        $allowedRoles = array_map(fn($role) => Role::tryFrom($role), $roles);

        if (!in_array($user->role, $allowedRoles, strict: true)) {
            abort(403);
        }

        return $next($request);
    }
}
