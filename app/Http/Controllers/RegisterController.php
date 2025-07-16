<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $roles = Role::all();
        return view('register', compact('roles'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:20|unique:users,id_number',
            'phone_number' => 'required|string|max:15|unique:users,phone_number',
            'role_id' => 'required|exists:roles,id',
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
            'role_id' => $request->role_id,
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