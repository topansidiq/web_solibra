@extends('admin.layouts.app')

@section('content')
<div class="w-full">
    <div class="flex flex-row gap-2 p-4">
        <div class="flex items-center w-fit">
            <a href="{{ route('users.index') }}" class="text-neutral-700 flex items-center">
                <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
            </a>
        </div>
        <div>
            <h3 class="text-xl text-neutral-700 font-bold">Detail Pengguna</h3>
            <p class="text-xs text-neutral-500">Informasi lengkap dari pengguna terpilih</p>
        </div>
    </div>

    <div class="mx-4 mb-4 p-4 rounded-sm bg-neutral-50 grid grid-cols-2 gap-5">
        {{-- Informasi Dasar --}}
        <div class="mb-6">
            <p class="text-xs text-neutral-500 mb-2">Informasi Dasar</p>
            <div class="grid gap-4">
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Nama Lengkap</div>
                    <div class="col-span-3">{{ $user->name }}</div>
                </div>
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Role</div>
                    <div class="col-span-3">{{ $user->role }}</div>
                </div>
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Email</div>
                    <div class="col-span-3"><a href="">{{ $user->email }}</a></div>
                </div>
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Nomor WhatsApp</div>
                    <div class="col-span-3">{{ $user->phone_number }}</div>
                </div>
            </div>
        </div>
        {{-- Informasi Akun --}}
        <div class="mb-6">
            <p class="text-xs text-neutral-500 mb-2">Informasi Akun</p>
            <div class="grid gap-4">
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Status Member</div>
                    <div class="col-span-3">{{ $user->member_status }}</div>
                </div>
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Status Akun</div>
                    <div class="col-span-3">{{ ucfirst($user->status_account) }}</div>
                </div>
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Tanggal Kedaluwarsa</div>
                    <div class="col-span-3">{{ $user->expired_date ? $user->expired_date->format('d-m-Y') : '-' }}</div>
                </div>
            </div>
        </div>
        {{-- Informasi Pribadi --}}
        <div class="mb-6">
            <p class="text-xs text-neutral-500 mb-2">Informasi Pribadi</p>
            <div class="grid gap-4">
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Jenis Kelamin</div>
                    <div class="col-span-3">{{ $user->gender == 'male' ? 'Laki-laki' : ($user->gender == 'female' ? 'Perempuan' : '-') }}</div>
                </div>
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">TT Lahir</div>
                    <div class="col-span-3 w-full">{{ $user->birth_date ?? '-' }}</div>
                </div>
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Umur</div>
                    <div class="col-span-3"><a href="">{{ $user->age ?? '-' }}</a></div>
                </div>
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Tipe Identitas</div>
                    <div class="col-span-3">{{ $user->id_type ?? '-' }}</div>
                </div>
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Nomor Identitas</div>
                    <div class="col-span-3">{{ $user->id_number ?? '-' }}</div>
                </div>
            </div>
        </div>
        {{-- Informasi Alamat --}}
        <div class="mb-6">
            <p class="text-xs text-neutral-500 mb-2">Informasi Alamat</p>
            <div class="grid gap-4">
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Alamat Lengkap</div>
                    <div class="col-span-3">{{ $user->address }}</div>
                </div>
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Kabupaten/Kota</div>
                    <div class="col-span-3">{{ $user->regency }}</div>
                </div>
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Provinsi</div>
                    <div class="col-span-3">{{ $user->province }}</div>
                </div>
            </div>
        </div>
        {{-- Informasi Lainnya --}}
        <div class="mb-6">
            <p class="text-xs text-neutral-500 mb-2">Informasi Alamat</p>
            <div class="grid gap-4">
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Pekerjaan</div>
                    <div class="col-span-3">{{ $user->jobs ?? '-' }}</div>
                </div>
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium">Pendidikan</div>
                    <div class="col-span-3">{{ $user->education ?? '-' }}</div>
                </div>
                <div class="grid grid-cols-4 text-sm border-b border-neutral-300 pb-1">
                    <div class="col-span-1 font-medium"> Jurusan / Kelas</div>
                    <div class="col-span-3">{{ $user->class_department ?? '-' }}</div>
                </div>

            </div>
        </div>
        {{-- Foto Profil --}}
        <div class="mb-6">
            <p class="text-xs text-neutral-500 mb-2">Profil</p>
            @if($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Foto Profil"
                     class="w-32 h-32 object-cover rounded">
            @else
                <p class="text-sm text-gray-500">Tidak ada foto profil</p>
            @endif
        </div>

        <div class="col-span-2 flex justify-end">
            <a href="{{ route('users.index') }}"
            class="text-xs bg-sky-800 text-white px-6 py-2 rounded hover:bg-sky-900 transition">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
