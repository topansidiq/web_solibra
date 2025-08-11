@extends('admin.layouts.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="flex flex-row gap-2 p-4">
        {{-- Back Button --}}
        <div class="flex items-center w-fit">
            <a href="{{ route('users.index') }}" class="text-neutral-700 flex items-center">
                <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
            </a>
        </div>
        <div>
            <h3 class="text-xl text-neutral-700 font-bold">Edit Pengguna</h3>
            <p class="text-xs text-neutral-500">Halaman ini digunakan untuk memperbarui data pengguna</p>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data"
        class="mx-4 mb-4 p-4 rounded-sm bg-neutral-50 relative">
        @csrf
        @method('PUT')

        {{-- Informasi Dasar --}}
        <div class="mb-6">
            <p class="text-xs text-neutral-500 mb-2">Informasi Dasar</p>
            <div class="grid grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium pt-2 pb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                </div>
                <div>
                    <label class="block text-sm font-medium pt-2 pb-1">Role</label>
                    <select name="role" class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                        @foreach(App\Models\Role::cases() as $role)
                            <option value="{{ $role->value }}" {{ $user->role == $role->value ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium pt-2 pb-1">E-mail</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                </div>
                <div>
                    <label class="block text-sm font-medium pt-2 pb-1">Nomor WhatsApp</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                        class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                </div>
            </div>
        </div>

        {{-- Informasi Akun --}}
        <div class="mb-6">
            <p class="text-xs text-neutral-500 mb-2">Informasi Akun</p>
            <div class="grid grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium">Status Member</label>
                    <input type="text" name="member_status" value="{{ old('member_status', $user->member_status) }}"
                        class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                </div>
                <div>
                    <label class="block text-sm font-medium">Status Akun</label>
                    <select name="status_account" class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                        <option value="active" {{ $user->status_account == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ $user->status_account == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="suspended" {{ $user->status_account == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Tanggal Kedaluwarsa</label>
                    <input type="date"
                        name="expired_date"
                        value="{{ old('expired_date', $user->expired_date ? \Carbon\Carbon::parse($user->expired_date)->format('Y-m-d') : '') }}"
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
                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}"
                        class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                </div>
                <div>
                    <label class="block text-sm font-medium">Umur</label>
                    <input type="number" name="age" value="{{ old('age', $user->age) }}"
                        class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                </div>
                <div>
                    <label class="block text-sm font-medium">Tipe Identitas</label>
                    <input type="text" name="id_type" value="{{ old('id_type', $user->id_type) }}"
                        class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                </div>
                <div>
                    <label class="block text-sm font-medium">Nomor Identitas</label>
                    <input type="text" name="id_number" value="{{ old('id_number', $user->id_number) }}"
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
                    <textarea name="address" class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">{{ old('address', $user->address) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium">Kabupaten/Kota</label>
                    <input type="text" name="regency" value="{{ old('regency', $user->regency) }}"
                        class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                </div>
                <div>
                    <label class="block text-sm font-medium">Provinsi</label>
                    <input type="text" name="province" value="{{ old('province', $user->province) }}"
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
                    <input type="text" name="jobs" value="{{ old('jobs', $user->jobs) }}"
                        class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                </div>
                <div>
                    <label class="block text-sm font-medium">Pendidikan</label>
                    <input type="text" name="education" value="{{ old('education', $user->education) }}"
                        class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                </div>
                <div>
                    <label class="block text-sm font-medium">Jurusan/Kelas</label>
                    <input type="text" name="class_department" value="{{ old('class_department', $user->class_department) }}"
                        class="form-input w-full border border-neutral-400 rounded-md p-2 text-xs">
                </div>
            </div>
        </div>

        {{-- Foto Profil --}}
        <div class="mb-6">
            <p class="text-xs text-neutral-500 mb-2">Profil</p>
            <input type="file" name="profile_picture"
                class="form-input w-1/3 border border-neutral-400 rounded-md p-2 text-xs">
            @if($user->profile_picture)
                <p class="text-sm mt-1 text-gray-500">Foto saat ini: {{ $user->profile_picture }}</p>
            @endif
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex justify-end gap-2">
            <a href="{{ route('users.index') }}"
            class="text-xs bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition">
                Batal
            </a>
            <button type="submit"
                class="text-xs bg-sky-800 text-white px-6 py-2 rounded hover:bg-sky-900 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
