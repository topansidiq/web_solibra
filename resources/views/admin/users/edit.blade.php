@extends('admin.layouts.app')

@section('content')
    <div class="w-fit">
        <div class="bg-teal-950 w-full p-4 rounded-t-lg cursor-move modal-add-header">
            <h2 class="text-xl font-bold flex align-middle justify-between">
                Edit Pengguna
            </h2>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST"
            class="grid grid-cols-2 gap-4 p-5 w-full bg-white shadow-md rounded">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block font-semibold">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-input w-full border-b border-slate-400 p-2"
                    required placeholder="Contoh: Budiono Siregar" value="{{ $user->name }}">
            </div>

            <div>
                <label for="id_number" class="block font-semibold">Nomor Identitas (KTP)</label>
                <input type="text" name="id_number" id="id_number"
                    class="form-input w-full border-b border-slate-400 p-2" required value="{{ $user->id_number }}">
            </div>

            <div>
                <label for="phone_number" class="block font-semibold">Nomor WhatsApp</label>
                <input type="text" name="phone_number" id="phone_number"
                    class="form-input w-full border-b border-slate-400 p-2" required value="{{ $user->phone_number }}">
            </div>

            <div>
                <label for="email" class="block font-semibold">E-mail</label>
                <input type="email" name="email" id="email" class="form-input w-full border-b border-slate-400 p-2"
                    required value="{{ $user->email }}">
            </div>

            <div>
                <label for="role_id" class="block font-semibold">Role</label>
                <select name="role_id" id="role_id" class="form-select w-full border-b border-slate-400 p-2" required>
                    <option disabled selected>
                        Role saat ini:
                        @if ($user->role_id == 1)
                            <span>Admin</span>
                        @elseif ($user->role_id == 2)
                            <span>Petugas Perpustakaan</span>
                        @elseif($user->role_id == 4)
                            <span>Anggota</span>
                        @endif
                    </option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-2 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>

    </div>
@endsection
