<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
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
        $users = User::paginate(20);
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
                'role' => ['required', new Enum(Role::class)],
                'phone_number' => 'required|string|max:255',
                'gender' => 'nullable|in:L,P',
                'birth_date' => 'nullable|date',
                'age' => 'nullable|integer|min:0|max:150',
                'id_type' => 'required|string|max:50',
                'id_number' => 'required|string|max:255',
                'address' => 'nullable|string|max:255',
                'regency' => 'nullable|string|max:100',
                'province' => 'nullable|string|max:100',
                'member_status' => 'nullable|string|max:50',
                'jobs' => 'nullable|string|max:100',
                'education' => 'nullable|string|max:100',
                'class_department' => 'nullable|string|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'nullable|string|min:8|confirmed',
                'status_account' => 'nullable|in:active,inactive,suspended',
                'expired_date' => 'nullable|date|after_or_equal:today',
                'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $user->update($validated);

            return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
        } catch (Throwable $e) {

            Log::error('Gagal update user', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui buku.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'role' => ['required', new Enum(Role::class)],
                'phone_number' => 'required|string|max:255',
                'gender' => 'nullable|in:L,P',
                'birth_date' => 'nullable|date',
                'age' => 'nullable|integer|min:0|max:150',
                'id_type' => 'required|string|max:50',
                'id_number' => 'required|string|max:255',
                'address' => 'nullable|string|max:255',
                'regency' => 'nullable|string|max:100',
                'province' => 'nullable|string|max:100',
                'member_status' => 'nullable|string|max:50',
                'jobs' => 'nullable|string|max:100',
                'education' => 'nullable|string|max:100',
                'class_department' => 'nullable|string|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'nullable|string|min:8|confirmed',
                'status_account' => 'nullable|in:active,inactive,suspended',
                'expired_date' => 'nullable|date|after_or_equal:today',
                'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $user = User::create([
                'name' => $request->name,
                'role' => Role::from($request->role),
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'age' => $request->age,
                'id_type' => $request->id_type,
                'id_number' => $request->id_number,
                'address' => $request->address,
                'regency' => $request->regency,
                'province' => $request->province,
                'member_status' => $request->member_status,
                'jobs' => $request->jobs,
                'education' => $request->education,
                'class_department' => $request->class_department,
                'email' => $request->email,
                'password' => $request->password ? bcrypt($request->password) : null,
                'status_account' => $request->status_account,
                'expired_date' => $request->expired_date,
            ]);

            if ($request->hasFile('profile_picture')) {
                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $user->profile_picture = $path;
                $user->save();
            }

            Notification::create([
                'user_id' => $user->id,
                'type' => 'new_member',
                'message' => "Selamat datang {$user->name}, anda telah berhasil membuat akun. Verifikasi nomor WhatsApp anda untuk dapat mengakses fitur lainnya.",
            ]);

            return redirect()->route('users.index')->with('success', 'Akun berhasil dibuat.');
        } catch (QueryException $e) {
            Log::error("Error: " . $e . ". Terjadi kesalahan saat membuat akun");
            return response()->json(['message' => 'Terjadi kesalahan saat membuat akun'], 422);
        } catch (\Exception $e) {
            Log::error('General error: ' . $e->getMessage());
            return response()->json(['message' => 'Something went wrong'], 500);
        }
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
