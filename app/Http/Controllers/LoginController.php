<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required_without:phone|email|exists:users,email',
            'phone' => 'required_without:email|numeric|exists:users,phone_number',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('password');

        // Determine whether to use email or phone for login
        if ($request->filled('email')) {
            $credentials['email'] = $request->email;
        } else {
            $credentials['phone_number'] = $request->phone;
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended($this->redirectTo());
        }

        return back()->withErrors([
            'email' => 'Login failed. Please check your credentials.',
        ])->withInput();
    }

    protected function redirectTo(): string
    {
        $role = Auth::user()->role->name;

        return match ($role) {
            "admin", "librarian" => '/admin/dashboard',
            "member" => '/member/dashboard',
            default => '/',
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}