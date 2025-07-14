@extends('admin.layouts.app')

@section('content')
    <div class="content flex flex-col flex-auto bg-gray-50 w-full">
        <script src="{{ asset('js/admin/user.js') }}"></script>
        <div class="title p-4 flex item-center justify-between">
            <div>
                <h3 class="text-xl font-bold">Daftar Pengguna</h3>
                <p class="text-sm">Ini adalah daftar pengguna terdaftar di perpustakaan</p>
            </div>

            <div x-data="{ open: false }">
                <div @click="open = true"
                    class="flex flex-row items-center justify-around cursor-pointer rounded-md px-2 py-1 bg-teal-950 text-slate-200">
                    <i data-lucide="plus" class="block w-5 h-5"></i>
                    <p class="text-sm">Tambah Pengguna</p>
                </div>

                <div x-cloak x-transition class="modal-add bg-white shadow-2xl rounded-lg fixed top-32 left-52 w-3/4"
                    x-show="open" x-data="formUser()">
                    <div class="bg-teal-950 w-full p-4 rounded-t-lg cursor-move modal-add-header">
                        <h2 class="text-xl font-bold flex align-middle justify-between">
                            <span class="block text-white">Tambah Pengguna Baru</span>
                            <button @click="open=false"><i class="block w-6 h-6 text-white text-sm cursor-pointer"
                                    data-lucide="x"></i></button>
                        </h2>
                    </div>

                    <form action="{{ route('users.store') }}" method="POST"
                        class="grid grid-cols-2 gap-4 p-5 w-full bg-white shadow-md rounded">
                        @csrf

                        <div>
                            <label for="name" class="block font-semibold">Nama Lengkap</label>
                            <input type="text" name="name" id="name"
                                class="form-input w-full border-b border-slate-400 p-2" required
                                placeholder="Contoh: Budiono Siregar" value="{{ old('name') }}">
                        </div>

                        <div>
                            <label for="id_number" class="block font-semibold">Nomor Identitas (KTP)</label>
                            <input type="text" name="id_number" id="id_number"
                                class="form-input w-full border-b border-slate-400 p-2" required
                                placeholder="Contoh: 1305072807020001" value="{{ old('id_number') }}">
                        </div>

                        <div>
                            <label for="phone_number" class="block font-semibold">Nomor WhatsApp</label>
                            <input type="text" name="phone_number" id="phone_number"
                                class="form-input w-full border-b border-slate-400 p-2" required
                                placeholder="Contoh: 081234567890" value="{{ old('phone_number') }}">
                        </div>

                        <div>
                            <label for="email" class="block font-semibold">E-mail</label>
                            <input type="email" name="email" id="email"
                                class="form-input w-full border-b border-slate-400 p-2" required
                                placeholder="Contoh: email@gmail.com" value="{{ old('email') }}">
                        </div>

                        <div>
                            <label for="role_id" class="block font-semibold">Role</label>
                            <select name="role_id" id="role_id" class="form-select w-full border-b border-slate-400 p-2"
                                required>
                                <option disabled selected>Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="password" class="block font-semibold">Password</label>
                            <input type="password" name="password" id="password"
                                class="form-input w-full border-b border-slate-400 p-2" required
                                placeholder="Masukkan Password: minimal 8 karakter">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block font-semibold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-input w-full border-b border-slate-400 p-2" required
                                placeholder="Konfirmasi password">
                        </div>

                        <div class="col-span-2 flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- Tabel Scrollable --}}
        <div class="mx-4">
            <table class="table font-sans w-full text-sm border-collapse border border-slate-300">
                <thead class="bg-teal-800 text-white text-sm sticky top-0 z-10">
                    <tr>
                        <th class="p-4 text-center w-5">No.</th>
                        <th class="p-4">Nama</th>
                        <th class="p-4">Nomor Identitas</th>
                        <th class="p-4">Role (Posisi)</th>
                        <th class="p-4">Tanggal Dibuat</th>
                        <th class="p-4">Nomor WhatsApps</th>
                        <th class="p-4">E-mail</th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                    @php
                        $number = 1;
                    @endphp
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-2 border border-slate-300 text-center">
                                {{ $number++ }}.
                            </td>
                            <td class="px-4 py-1 border border-slate-300">
                                <div class="flex flex-row gap-2 justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        {{-- Edit Book Button --}}
                                        <a href="{{ route('users.edit', $user->id) }}" class="block">
                                            <i data-lucide="edit" class="w-4 h-4 text-blue-500"></i>
                                        </a>

                                        {{-- Book Title --}}
                                        <p class="text-left">{{ $user->name }}</p>
                                    </div>

                                    {{-- Delete Book Button --}}
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-book-btn">
                                            <i data-lucide="trash-2" class="w-4 h-4 text-red-500"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-center">{{ $user->id_number }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                @if ($user->role_id == 4)
                                    <span>Anggota</span>
                                @elseif ($user->role_id == 2)
                                    <span>Petugas Perpustakaan</span>
                                @elseif ($user->role_id == 1)
                                    <span>Admin</span>
                                @endif
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-center">{{ $user->created_at }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center mx-auto">
                                @if ($user->phone_number_verified === 'unverified')
                                    <form action="{{ route('users.verified-phone-number', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Verifikasi nomor telephone?')">
                                        @csrf
                                        @method('PATCH')
                                        {{ $user->phone_number }}
                                        <button
                                            class="bg-gray-300 px-2 border border-slate-500 rounded-2xl hover:cursor-pointer hover:bg-gray-600 hover:text-slate-50"
                                            type="submit" title="Verifikasi Nomor WhatsApp">
                                            <span class=" unverified">unverified</span>
                                        </button>
                                    </form>
                                @elseif ($user->phone_number_verified === 'verified')
                                    {{ $user->phone_number }} <span
                                        class="bg-teal-400 px-2 border border-slate-500 rounded-2xl hover:cursor-pointer verified">Terverifikasi</span>
                                @endif
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-left">{{ $user->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $users->links() }}
        </div>
    </div>
@endsection
