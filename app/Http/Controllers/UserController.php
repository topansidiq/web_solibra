<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Enum;
use Throwable;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::paginate(20); // Paginate users, 20 per page
        return view("admin.users.index", compact("users", "user"));
    }

    public function edit(User $user)
    {
        $user = User::findOrFail($user->id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'id_number' => 'required|string|max:20|unique:users,id_number,' . $user->id,
                'role' => ['required', new Enum(Role::class)],
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone_number' => 'required|string|max:15|unique:users,phone_number,' . $user->id,
            ]);

            // Update buku
            $user->update($validated);

            return redirect()->route('users.index')->with('success', 'Buku berhasil diperbarui.');
        } catch (Throwable $e) {
            // Log error untuk debugging
            Log::error('Gagal update user', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui buku.',
                'error' => $e->getMessage(), // Bisa dihapus di production
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:20|unique:users,id_number',
            'phone_number' => 'required|string|max:15|unique:users,phone_number',
            'role' => ['required', new Enum(Role::class)],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Save user first
        $user = User::create([
            'name' => $request->name,
            'id_number' => $request->id_number,
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

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }


    public function verifiedPhoneNumber(User $user)
    {
        $user->phone_number_verified->update([
            'phone_number_verified' => true,
        ]);
        return redirect()->route('users.index')->with('success', 'Phone number verification status updated successfully.');
    }

    public function destroy(User $user)
    {

        // Hapus buku
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Buku berhasil dihapus.');
    }
}
