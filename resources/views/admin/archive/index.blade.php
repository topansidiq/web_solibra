@extends('admin.layouts.app')

@section('content')
    <div class="content flex flex-col flex-auto bg-gray-50 w-full" x-data="{ openAddborrowModal: false }" x-cloak>
        <div x-data="{ show: {{ session('error') ? 'true' : 'false' }} }" x-show="show" x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition
            x-cloak>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold bg-red-300 px-2 py-1 rounded-sm">Gagal</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
        <div x-data="{ show: {{ session('success') ? 'true' : 'false' }} }" x-show="show" x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition
            x-cloak>
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
                    <h3 class="text-xl text-neutral-700 font-bold">Arsip Peminjaman</h3>
                    <p class="text-xs text-neutral-500">Menu ini menampilkan arsip peminjaman yang telah selesai</p>
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
                        <th class="p-4 text-center">Tanggal Pengembalian</th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                    @foreach ($borrows as $index => $borrow)
                        <tr>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ $index + 1 }}
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
                            <td class="px-4 py-1 border border-slate-300 text-center ">
                                {{ \Carbon\Carbon::parse($borrow->return_date)->format('d-m-Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $borrows->links() }}
        </div>
    </div>
@endsection
