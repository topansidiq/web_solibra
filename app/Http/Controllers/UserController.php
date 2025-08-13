<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use App\Models\WhatsApp;
use App\Services\WhatsAppBotService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Enum;
use Throwable;

class UserController extends Controller
{
    protected $whatsapp;

    public function __construct(WhatsAppBotService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function index()
    {
        $user = Auth::user();
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view("admin.users.index", compact("users", "user"));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function edit(User $user)
    {
        $user = User::findOrFail($user->id);
        return view('admin.users.update', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'role' => ['required', new Enum(Role::class)],
                'phone_number' => 'required|string|max:255',
                'gender' => 'nullable|in:male,female',
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
                'email' => 'required|email|unique:users,email,' . $user->id,
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
                'message' => 'Terjadi kesalahan saat memperbarui pengguna.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'name'                  => 'required|string|max:255',
                'role'                  => ['required', new Enum(Role::class)],
                'phone_number'          => 'required|string|max:255',
                'email'                 => 'required|email|unique:users,email',
                'password'              => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8',

            ]);

            // Pastikan password dan konfirmasi cocok
            if ($request->password !== $request->password_confirmation) {
                return back()->with('error', 'Konfirmasi password salah. Mohon periksa kembali');
            }

            // Gabung tempat & tanggal lahir
            $birth = null;
            if ($request->filled('birth_place') || $request->filled('birth_date')) {
                $birth = trim(($request->birth_place ?? '') . ', ' . ($request->birth_date ?? ''), ', ');
            }

            // Upload foto profil jika ada
            if ($request->hasFile('profile_picture')) {
                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            }

            // Simpan user
            $user = User::create([
                'name'            => $request->name,
                'role'            => Role::from($request->role), // Hati-hati kalau request.role tidak cocok enum
                'phone_number'    => $request->phone_number,
                'email'           => $request->email,
                'password'        => $request->password ? bcrypt($request->password) : null,

                'expired_date'    => $request->expired_date,
                'birth_date'      => $birth,
                'age'             => $request->age,
                'id_type'         => $request->id_type,
                'member_status'   => $request->member_status,
                'status_account'  => $request->status_account ?? 'active',
                'id_number'       => $request->id_number,
                'gender'          => $request->gender,
                'address'         => $request->address,
                'regency'         => $request->regency,
                'province'        => $request->province,
                'jobs'            => $request->jobs,
                'education'       => $request->education,
                'class_department' => $request->class_department,
                'profile_picture' => $path,
            ]);

            // Notifikasi ke user
            Notification::create([
                'user_id' => $user->id,
                'type'    => 'new_member',
                'message' => "Selamat datang {$user->name} di Perpustakaan Umum Kota Solok. Status keanggotaan anda saat ini adalah <b>new</b>. Lengkapi data anda dan lakukan verifikasi nomor WhatsApp untuk mengaktikan status keanggotaan!<br>
                <a href='" . route('member.verification') . "'>Verifikasi Nomor WhatsApp</a> |
                <a href='" . route('member.account.edit') . "'>Lengkapi Profil</a>"
            ]);

            // Notifikasi tambahan
            Notification::create([
                'user_id' => $user->id,
                'type'    => 'new_member',
                'message' => "Lengkapi data diri anda dan lakukan validasi di Perpustakaam Umum Kota Solok",
            ]);

            return redirect()->route('users.index')->with('success', 'Akun berhasil dibuat.');
        } catch (QueryException $e) {
            // Error database (misal constraint, kolom salah, dll)
            Log::error("QueryException: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan pada database: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Error umum
            Log::error('General error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return back()->with('error', $e->getMessage());
        }
    }

    public function verifiedPhoneNumber(User $user)
    {
        $user->update([
            'is_phone_verified' => true,
        ]);

        $message = "Selamat, nomor anda telah terverifikasi. Status anggota saat ini adalah aktif. Lakukan validasi data ke Perpustakaan Umum Kota Solok untuk dapat menggunakan fitur peminjaman.";

        Notification::create([
            'user_id' => $user->id,
            'type' => 'phone_verified',
            'message' => $message
        ]);

        $this->whatsapp->sendMessage($user->phone_number, $message);

        return redirect()->route('users.index')->with('success', 'Phone number verification status updated successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {

        // Hapus buku
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function userValidation(Request $request, WhatsAppBotService $bot) {
        $request->validate(['user_id' => 'required|exists:users,id']);

        $user = User::findOrFail($request->user_id);

        if ($user->member_status == 'new' && $user->member_status == 'active') {
            return redirect()->back()->with('error', 'Anggota ini belum menverifikasi data dan nomor HP');
        }

        $user->update(['member_status' => 'validated']);
        $user->save();

        $message = "Selamat, status keanggotaan anda sekarang sudah tervalidasi. Anda dapat menikmati layanan peminjaman dan lainnya. Terima kasih";

        Notification::create([
            'user_id' => $user->id,
            'type' => 'member_validation',
            'message' => $message,
            'is_read' => false
        ]);

        $bot->sendMessage(formattedPhoneNumberToUs62($user->phone_number), "> Layanan Chatbot Perpustakaan Umum Kota Solok\n\n{$message}");

        return redirect()->back()->with('success', 'Anggota telah berhasil divalidasi!');
    }
}
