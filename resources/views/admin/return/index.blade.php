@extends('admin.layouts.app')

@section('content')
    <div class="content flex flex-col flex-auto bg-gray-50 w-full" x-data="{ openAddborrowModal: false }" x-cloak>
        <div x-data="{ show: {{ session('error') ? 'true' : 'false' }} }" x-show="show"
            x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition x-cloak>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold bg-red-300 px-2 py-1 rounded-sm">Gagal</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
        <div x-data="{ show: {{ session('success') ? 'true' : 'false' }} }" x-show="show"
            x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition x-cloak>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold bg-green-300 px-2 py-1 rounded-sm">Berhasil</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
        <div class="title p-4 flex flex-row items-center justify-between">
            {{-- Header/Page Title/Page Description --}}
            <div class="flex flex-row gap-2">
                {{-- Go to Dashboard --}}
                <div class="flex items-center w-fit">
                    <a href="{{ route('dashboard.index') }}" class="text-teal-950 font-bold">
                        <i data-lucide="repeat" class="w-8 h-8 inline"></i>
                        <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                    </a>
                </div>

                <div class="">
                    <h3 class="text-xl text-neutral-700 font-bold">Daftar Peminjaman Aktif</h3>
                    <p class="text-xs text-neutral-500">Menu ini menampilkan daftar peminjaman yang aktif dan ditargetkan
                        untuk proses pengembalian</p>
                </div>
            </div>
        </div>

        {{-- Tabel Scrollable --}}
        <div class="mx-4">
            <table class="table font-sans w-full">
                <thead class="bg-sky-800 text-white text-sm sticky top-0 z-10">
                    <tr>
                        <th class="p-4 text-center">No.</th>
                        <th class="p-4">Judul Buku</th>
                        <th class="p-4">Peminjam</th>
                        <th class="p-4 text-center">Status Peminjaman</th>
                        <th class="p-4 text-center">Tanggal Pengembalian</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                    @php
                        $number = 1;
                    @endphp
                    @foreach ($borrows as $borrow)
                        @if ($borrow->status === 'archive')
                            @continue
                        @endif
                        <tr>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ $number++ }}
                            </td>
                            <td class="px-4 py-1 border border-slate-300">
                                <div class="flex items-center justify-between">
                                    <p class="outline-0">
                                        <a href="{{ route('borrows.show', $borrow->id) }}">
                                            {{ Str::limit($borrow->book->clean_title, 35) ?? '-' }}
                                        </a>
                                    </p>
                                    <form action="{{ route('borrows.destroy', $borrow->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus peminjaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline text-xs">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="px-4 py-1 border border-slate-300
                            ">
                                {{ $borrow->user->name ?? '-' }}
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                @if ($borrow->status === 'confirmed')
                                    Aktif
                                @elseif ($borrow->status === 'overdue')
                                    Terlambat {{ (int) now()->diffInDays($borrow->due_date) }} hari
                                @elseif ($borrow->status === 'returned')
                                    Sudah Dikembalikan
                                @endif
                            </td>

                            <td class="px-4 py-1 border border-slate-300 text-center ">
                                @if ($borrow->status !== 'returned')
                                    <span>-</span>
                                @else
                                    <span>{{ $borrow->return_date }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-1 border border-slate-300">
                                <div class="flex justify-center items-center h-full">
                                    @if ($borrow->status === 'returned')
                                        <span class="px-2 py-1 bg-gray-400 rounded-md text-neutral-50">
                                            Sudah Dikembalikan
                                        </span>
                                    @else
                                        <a href="{{ route('return.show', $borrow) }}"
                                            class="px-2 py-1 bg-green-500 rounded-md text-neutral-50">
                                            Kembalikan
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $borrows->links() }}
        </div>
    </div>
@endsection
