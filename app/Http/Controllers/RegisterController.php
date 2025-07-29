<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:20|unique:users,id_number',
            'phone_number' => 'required|string|max:15|unique:users,phone_number',
            'role' => ['required', new Enum(Role::class)],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gender' => 'nullable|string|max:255',
            'place_birth' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'last_education' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
        ]);

        // Save user first
        $user = User::create([
            'name' => $request->name,
            'id_number' => $request->id_number,
            'gender' => $request->gender,
            'place_birth' => $request->place_birth,
            'birth_date' => $request->birth_date,
            'last_education' => $request->last_education,
            'job' => $request->job,
            'phone_number' => $request->phone_number,
            'role' => Role::from($request->role),
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Save profile picture to storage
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
            $user->save();
        }

        Auth::login($user);

        return redirect()->route('member.index')->with('success', 'User created successfully.');
    }
}
