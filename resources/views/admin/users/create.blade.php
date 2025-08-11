@extends('admin.layouts.app')

@section('content')
    <div class="w-full">
        <div x-data="{ show: {{ session('error') ? 'true' : 'false' }} }" x-show="show"
            x-init="setTimeout(() => show = false, 120000)" class="transition-all ease-in-out" x-transition x-cloak>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold bg-red-300 px-2 py-1 rounded-sm">Gagal</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
        {{-- Header --}}
        <div class="flex flex-row gap-2 p-4">
            {{-- Back Button --}}
            <div class="flex items-center w-fit">
                <a href="{{ route('users.index') }}" class="text-neutral-700 flex items-center">
                    <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                </a>
            </div>
            <div>
                <h3 class="text-xl text-neutral-700 font-bold">Tambah Pengguna Baru</h3>
                <p class="text-xs text-neutral-500">Halaman ini digunakan untuk menambah data pengguna baru</p>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"
            class="mx-4 mb-4 p-4 rounded-sm bg-neutral-50">
            @csrf

            {{-- Informasi Dasar --}}
            <div class="mb-6">
                <p class="text-xs text-neutral-500 mb-2">Informasi Dasar</p>
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium pt-2 pb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium pt-2 pb-1">Role</label>
                        <select name="role" class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs"
                            required>
                            @foreach(App\Models\Role::cases() as $role)
                                <option value="{{ $role->value }}" {{ old('role') == $role->value ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium pt-2 pb-1">E-mail</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium pt-2 pb-1">Nomor WhatsApp</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs" required>
                    </div>
                </div>
            </div>

            {{-- Informasi Akun --}}
            <div class="mb-6">
                <p class="text-xs text-neutral-500 mb-2">Informasi Akun</p>
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Status Member</label>
                        <input type="text" name="member_status" value="{{ old('member_status') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Status Akun</label>
                        <select name="status_account"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                            <option value="">-- Pilih Status --</option>
                            <option value="active" {{ old('status_account') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status_account') == 'inactive' ? 'selected' : '' }}>Nonaktif
                            </option>
                            <option value="suspended" {{ old('status_account') == 'suspended' ? 'selected' : '' }}>Suspended
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Tanggal Kedaluwarsa</label>
                        <input type="date" name="expired_date" value="{{ old('expired_date') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                    </div>
                </div>
            </div>

            {{-- Informasi Pribadi --}}
            <div class="mb-6">
                <p class="text-xs text-neutral-500 mb-2">Informasi Pribadi</p>
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Jenis Kelamin</label>
                        <select name="gender" class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Tempat Lahir</label>
                        <input type="text" name="birth_place" value="{{ old('birth_place') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Tanggal Lahir</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Umur</label>
                        <input type="number" name="age" value="{{ old('age') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Tipe Identitas</label>
                        <select name="id_type" class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                            <option value="">-- Pilih Type Identitas --</option>
                            <option value="KTP" {{ old('id_type')}}>KTP</option>
                            <option value="passport" {{ old('id_type')}}>Passport</option>
                            <option value="Kartu Pelajar" {{ old('id_type')}}>Kartu Pelajar</option>
                        </SElect>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Nomor Identitas</label>
                        <input type="text" name="id_number" value="{{ old('id_number') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                    </div>
                </div>
            </div>

            {{-- Informasi Alamat --}}
            <div class="mb-6">
                <p class="text-xs text-neutral-500 mb-2">Informasi Alamat</p>
                <div class="grid grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium">Alamat Lengkap</label>
                        <textarea name="address"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">{{ old('address') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Kabupaten/Kota</label>
                        <input type="text" name="regency" value="{{ old('regency') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Provinsi</label>
                        <input type="text" name="province" value="{{ old('province') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                    </div>
                </div>
            </div>

            {{-- Pendidikan & Pekerjaan --}}
            <div class="mb-6">
                <p class="text-xs text-neutral-500 mb-2">Informasi Lainnya</p>
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Pekerjaan</label>
                        <input type="text" name="jobs" value="{{ old('jobs') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Pendidikan</label>
                        <input type="text" name="education" value="{{ old('education') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Jurusan/Kelas</label>
                        <input type="text" name="class_department" value="{{ old('class_department') }}"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                    </div>
                </div>
            </div>

            {{-- Password & Remember Token --}}
            <div class="mb-6">
                <p class="text-xs text-neutral-500 mb-2">Keamanan Akun</p>
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Password</label>
                        <input type="password" name="password"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                    </div>
                </div>
            </div>

            {{-- Foto Profil --}}
            <div class="mb-6">
                <p class="text-xs text-neutral-500 mb-2">Profil</p>
                <input type="file" name="profile_picture"
                    class="form-input w-1/3 border border-neutral-400 rounded-md p-2 text-xs">
            </div>

            {{-- Tombol Simpan --}}
            <div class="flex justify-end gap-2">
                <a href="{{ route('users.index') }}"
                    class="text-xs bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition">
                    Batal
                </a>
                <button type="submit" class="text-xs bg-sky-800 text-white px-6 py-2 rounded hover:bg-sky-900 transition">
                    Simpan
                </button>
            </div>

        </form>
    </div>
@endsection
