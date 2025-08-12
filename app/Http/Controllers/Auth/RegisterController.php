<?php

namespace App\Http\Controllers\Auth;

use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|unique:users,phone_number',
            'role' => ['required', new Enum(Role::class)],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',

            'id_type' => 'nullable|string|max:255',
            'id_number' => 'nullable|string|max:255|unique:users,id_number',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'education' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
        ]);

        $birth = $request->birth_place . ', ' . $request->birth_date;

        // Save user first
        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'role' => Role::from($request->role),
            'email' => $request->email,
            'password' => bcrypt($request->password),

            'id_type' => $request->id_type,
            'id_number' => $request->id_number,
            'gender' => $request->gender,
            'birth_date' => $birth,
            'last_education' => $request->last_education,
            'job' => $request->job,
        ]);

        Auth::guard('member')->login($user);

        Notification::create([
            'user_id' => $user->id,
            'type' => 'account_created',
            'message' => "Selamat datang, {$user->name}. Anda telah berhasil membuat akun. Untuk menikmati layanan kami, silakan lengkapi profil Anda.Verifikasi nomor telepon/whatsapp anda untuk mendapatkan layanan peminjaman buku.",
        ]);

        return redirect()->route('member.index')->with('success', 'Berhasil membuat akun!');
    }
}
