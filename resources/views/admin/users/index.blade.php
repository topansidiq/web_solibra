@extends('admin.layouts.app')

@section('content')
    <div class="content flex flex-col flex-auto bg-gray-50 w-full">
        <script src="{{ asset('js/admin/user.js') }}"></script>
        <div class="title p-4 flex items-center justify-between">
            {{-- Header/Page Title/Page Description --}}
            <div class="flex flex-row gap-2">
                {{-- Go to Dashboard --}}
                <div class="flex items-center w-fit">
                    <a href="{{ route('dashboard.index') }}" class="text-teal-950 font-bold">
                        <i data-lucide="user" class="w-8 h-8 inline"></i>
                        <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                    </a>
                </div>

                <div class="">
                    <h3 class="text-xl text-neutral-700 font-bold">Daftar Pengguna</h3>
                    <p class="text-xs text-neutral-500">Menu ini menampilkan daftar pengguna di perpustakaan</p>
                </div>
            </div>
            <div>
                <a href="{{ route('users.create') }}"
                    class="flex flex-row items-center justify-around cursor-pointer rounded-md px-2 py-1 bg-sky-800 text-slate-200">
                    <i data-lucide="plus" class="block w-5 h-5"></i>
                    <p class="text-sm">Tambah Pengguna</p>
                </a>
            </div>
        </div>

        {{-- Tabel Scrollable --}}
        <div class="mx-4">
            <table class="table font-sans w-full text-sm border-collapse border border-slate-300">
                <thead class="bg-sky-800 text-white text-sm sticky top-0 z-10">
                    <tr>
                        <th class="p-4 text-center w-5">No.</th>
                        <th class="p-4">Nama</th>
                        <th class="p-4">Nomor Identitas</th>
                        <th class="p-4">Role (Posisi)</th>
                        <th class="p-4">Tanggal Dibuat</th>
                        <th class="p-4">Nomor WhatsApps</th>
                        <th class="p-4">E-mail</th>
                        <th class="p-4 text-center">Aksi</th> {{-- kolom baru --}}
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
                                <p class="text-left">{{ $user->name }}</p>
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-center">{{ $user->id_number }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center">{{ $user->role->label() }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ $user->created_at->format('m-d-Y') }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                @if ($user->is_phone_verified === 0)
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
                                @elseif ($user->is_phone_verified === 1)
                                    {{ $user->phone_number }} <span
                                        class="bg-teal-400 px-2 border border-slate-500 rounded-2xl hover:cursor-pointer verified">Terverifikasi</span>
                                @endif
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-left">{{ $user->email }}</td>

                            {{-- kolom aksi --}}
                            <td class="px-4 py-1 border border-slate-300 text-center w-32">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('users.show', $user->id) }}"
                                        class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1 rounded">
                                        Detail
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="bg-sky-800 hover:bg-sky-900 text-white text-xs px-3 py-1 rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded flex items-center justify-center h-[25px]">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
@endsection
