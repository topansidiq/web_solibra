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
                    <a href="{{ route('return.index') }}" class="text-teal-950 font-bold">
                        <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                    </a>
                </div>

                <div class="">
                    <h3 class="text-xl text-neutral-700 font-bold">Detail Pengembalian</h3>
                    <p class="text-xs text-neutral-500">Menu ini menampilkan detail pengembalian.</p>
                </div>
            </div>
        </div>
        <div class="rounded-sm shadow-md border border-neutral-200 p-4 grid gap-3">
            <p class="text-3xl font-semibold">Apakah Anda Yakin Ingin Menkonfirmasi Pengembalian Buku Ini?</p>
            <form action="{{ route('borrows.return', $borrow->id) }}" method="POST"
                onsubmit="return confirm('Konfirmasi pengembalian?')">
                @csrf
                @method('PATCH')
                <input type="hidden" name="book_id" value="{{ $borrow->book_id }}">
                <input type="hidden" name="user_id" value="{{ $borrow->user_id }}">
                <button class="px-3 text-xl py-2 rounded-md bg-sky-700 text-neutral-50 cursor-pointer hover:bg-sky-950"
                    type="submit" title="Konfirmasi Peminjaman">
                    Konfirmasi Pengembalian
                </button>
            </form>
        </div>
        <div class="mx-4 grid grid-cols-9 rounded-sm shadow-md border border-neutral-200">
            {{-- Cover --}}
            <div class="col-span-2">
                <div
                    class="h-full bg-gradient-to-bl from-sky-700 to-sky-400 text-white flex items-center justify-center rounded shadow text-3xl font-bold">
                    @if ($borrow->book->cover)
                        <img src="{{ 'storage/' . $borrow->book->cover }}" alt="{{ $borrow->book->clean_title }}">
                    @else
                        {{ $borrow->book->initial }}
                    @endif
                </div>
            </div>

            {{-- Detail --}}
            <div class="col-span-7 flex flex-col px-4 text-sm">
                <div class="flex border-b border-neutral-300 py-2">
                    <div class="flex-1/5 font-bold text-neutral-700">Nomor Peminjaman</div>
                    <div class="flex-4/5">{{ $borrow->id }}</div>
                </div>
                <div class="flex border-b border-neutral-300 py-2">
                    <div class="flex-1/5 font-bold text-neutral-700">Nama Peminjam</div>
                    <div class="flex-4/5">{{ $borrow->user->name }}</div>
                </div>
                <div class="flex border-b border-neutral-300 py-2">
                    <div class="flex-1/5 font-bold text-neutral-700">Kontak Peminjam</div>
                    <div class="flex-4/5">
                        {{ $borrow->user->phone_number }} | <span class="text-sky-400">{{ $borrow->user->email }}</span>
                    </div>
                </div>
                <div class="flex border-b border-neutral-300 py-2">
                    <div class="flex-1/5 font-bold text-neutral-700">Detail Barang</div>
                    <div class="flex-4/5">
                        <span>({{ $borrow->book->physical_shape }}) {{ $borrow->book->clean_title }}</span>
                    </div>
                </div>
                <div class="flex border-b border-neutral-300 py-2 items-center">
                    <div class="flex-1/5 font-bold text-neutral-700">Status Peminjaman</div>
                    <div class="flex-4/5">
                        @if ($borrow->status === 'unconfirmed')
                            <div class="flex items-start gap-3">
                                <p>Belum Dikonfirmasi</p>
                                <form action="{{ route('borrows.confirm', $borrow->id) }}" method="POST"
                                    onsubmit="return confirm('Setujui peminjaman buku ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="book_id" value="{{ $borrow->book_id }}">
                                    <input type="hidden" name="user_id" value="{{ $borrow->user_id }}">
                                    <button
                                        class="px-1 text-xs py-0.5 rounded-md bg-sky-700 text-neutral-50 cursor-pointer hover:bg-sky-950"
                                        type="submit" title="Konfirmasi Peminjaman">
                                        Konfirmasi
                                    </button>
                                </form>
                            </div>
                        @elseif ($borrow->status === 'confirmed')
                            @if ($borrow->extend === 3)
                                <div class="flex items-start gap-3">
                                    <p>Diperpanjang pada {{ $borrow->updated_at }}</p>
                                    <p class="text-red-400">
                                        <span>Tidak bisa melakukan perpanjangan lagi (maks. 3)</span> |
                                    <form class="inline" action="{{ route('borrows.return', $borrow->id) }}" method="POST"
                                        onsubmit="return confirm('Konfirmasi pengembalian?')">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="px-1 text-xs py-0.5 rounded-md bg-sky-700 text-neutral-50 cursor-pointer hover:bg-sky-950"
                                            type="submit" title="Kembalikan sekarang">
                                            Dikembalikan
                                        </button>
                                    </form>
                                    </p>
                                </div>
                            @else
                                <div class="flex items-start gap-3">
                                    <p>Diperpanjang pada {{ $borrow->updated_at }}</p>
                                    <form action="{{ route('borrows.extend', $borrow->id) }}" method="POST"
                                        onsubmit="return confirm('Konfirmasi Perpanjangan??')">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="px-1 text-xs py-0.5 rounded-md bg-sky-700 text-neutral-50 cursor-pointer hover:bg-sky-950"
                                            type="submit" title="Konfirmasi Perpanjangan">
                                            Perpanjang Peminjaman
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @elseif ($borrow->status === 'overdue' || $borrow->due_date < now())
                            <div class="flex items-start gap-3">
                                <p>Jatuh tempo {{ $borrow->due_date->diffForHumans() }}</p>
                                <form action="{{ route('borrows.return', $borrow->id) }}" method="POST"
                                    onsubmit="return confirm('Konfirmasi pengembalian?')">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="book_id" value="{{ $borrow->book_id }}">
                                    <input type="hidden" name="user_id" value="{{ $borrow->user_id }}">
                                    <button
                                        class="px-1 text-xs py-0.5 rounded-md bg-sky-700 text-neutral-50 cursor-pointer hover:bg-sky-950"
                                        type="submit" title="Konfirmasi Peminjaman">
                                        Konfirmasi Pengembalian
                                    </button>
                                </form>
                            </div>
                        @elseif ($borrow->status === 'return')
                            <div class="flex items-start gap-3">
                                <p>Telah di kembalikan {{ $borrow->return_date->diffForHumans() }}</p>
                                <form action="{{ route('borrows.archive', $borrow->id) }}" method="POST"
                                    onsubmit="return confirm('Arsipkan peminjaman?')">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="book_id" value="{{ $borrow->book_id }}">
                                    <input type="hidden" name="user_id" value="{{ $borrow->user_id }}">
                                    <button
                                        class="px-1 text-xs py-0.5 rounded-md bg-sky-700 text-neutral-50 cursor-pointer hover:bg-sky-950"
                                        type="submit" title="Konfirmasi Peminjaman">
                                        Arsipkan
                                    </button>
                                </form>
                            </div>
                        @elseif ($borrow->status === 'extend')
                            <div class="flex items-start gap-3">
                                <p>Telah diperpanjang {{ $borrow->updated_at->diffForHumans() }}</p>
                                <form action="{{ route('borrows.extend', $borrow->id) }}" method="POST"
                                    onsubmit="return confirm('Konfirmasi perpanjangan?')">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="book_id" value="{{ $borrow->book_id }}">
                                    <input type="hidden" name="user_id" value="{{ $borrow->user_id }}">
                                    <button
                                        class="px-1 text-xs py-0.5 rounded-md bg-sky-700 text-neutral-50 cursor-pointer hover:bg-sky-950"
                                        type="submit" title="Konfirmasi Peminjaman">
                                        Perpanjang
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="flex border-b border-neutral-300 py-2 items-center">
                    <div class="flex-1/5 font-bold text-neutral-700">Perpanjangan</div>
                    <div class="flex-4/5">
                        @if ($borrow->status == 'extend')
                            <span>Aktif</span>
                        @else
                            <span>-</span>
                        @endif
                    </div>
                </div>
                <div class="flex border-b border-neutral-300 py-2 items-center">
                    <div class="flex-1/5 font-bold text-neutral-700">Total Perpanjang</div>
                    <div class="flex-4/5">
                        @if ($borrow->status == 'extend')
                            <span>{{ $borrow->extend }}/3</span>
                        @else
                            <span>-</span>
                        @endif
                    </div>
                </div>
                <div class="flex border-b border-neutral-300 py-2 items-center">
                    <div class="flex-1/5 font-bold text-neutral-700">Tanggal Pengembalian</div>
                    <div class="flex-4/5">
                        @if ($borrow->status !== 'return' || $borrow->status !== 'archive')
                            <span>-</span>
                        @else
                            {{ $borrow->return_date->format('d-m-Y h:i') }}
                        @endif
                    </div>
                </div>
                <div class="flex border-b border-neutral-300 py-2 items-center">
                    <div class="flex-1/5 font-bold text-neutral-700">Jatuh Tempo</div>
                    <div class="flex-4/5">
                        {{ $borrow->due_date->translatedFormat('l, d F Y') }}
                    </div>
                </div>
                <div class="flex border-b border-neutral-300 py-2 items-center">
                    <div class="flex-1/5 font-bold text-neutral-700">Terakhir Diperbarui</div>
                    <div class="flex-4/5">
                        @if ($borrow->updated_at)
                            {{ $borrow->updated_at->format('d-m-Y h:i') }}
                        @else
                            <span>-</span>
                        @endif
                    </div>
                </div>
                <div class="flex border-b border-neutral-300 py-2 items-center">
                    <div class="flex-1/5 font-bold text-neutral-700">Data Barang</div>
                    <div class="flex-4/5">
                        <div x-data="{ open: false }" class="relative w-2xl">
                            <!-- Tombol -->
                            <button @click="open = !open"
                                class="w-full border border-neutral-300 rounded px-2 bg-white text-left">
                                Lihat Data Barang
                            </button>

                            <!-- Dropdown list -->
                            <div x-show="open" @click.outside="open = false" @mouseleave="open=false"
                                class="absolute mt-1 w-full border rounded bg-white shadow-lg z-50 max-h-72 overflow-y-auto">
                                @foreach ($borrow->book->toArray() as $field => $value)
                                    <div class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                        <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $field)) }}</span>:
                                        <span>{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex py-2 items-center">
                    <div class="flex-1/5 font-bold text-neutral-700">Data Peminjam</div>
                    <div class="flex-4/5">
                        <div x-data="{ open: false }" class="relative w-2xl">
                            <!-- Tombol -->
                            <button @click="open = !open"
                                class="w-full border border-neutral-300 rounded px-2 bg-white text-left">
                                Lihat Data Peminjam
                            </button>

                            <!-- Dropdown list -->
                            <div x-show="open" @click.outside="open = false" @mouseleave="open=false"
                                class="absolute mt-1 w-full border rounded bg-white shadow-lg z-50 max-h-72 overflow-y-auto">
                                @foreach ($borrow->user->toArray() as $field => $value)
                                    <div class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                        <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $field)) }}</span>:
                                        <span>{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-5 flex justify-between">
            <div class="">
                <div class="py-2">
                    <p class="text-xs">Anggota ini memiliki {{ $borrows->count() }} riwayat peminjaman</p>

                    <div x-data="{ open: false }" class="relative w-xl text-sm py-3">
                        <!-- Tombol -->
                        <button @click="open = !open"
                            class="w-full border border-neutral-300 rounded px-3 py-2 bg-white text-left">
                            Lihat Riwayat
                        </button>

                        <!-- Dropdown list -->
                        <div x-show="open" @click.outside="open = false" @mouseleave="open=false"
                            class="absolute mt-1 w-full border rounded bg-white shadow-lg z-50 max-h-72 overflow-y-auto text-sm">

                            @forelse ($borrows as $history)
                                <div class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                    <div class="font-semibold">{{ $history->book->clean_title ?? 'Tidak diketahui' }}
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        Pinjam: {{ $history->borrowed_at }} <br>
                                        Jatuh Tempo: {{ $history->due_date }} <br>
                                        Status: {{ ucfirst($history->status) }}
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <div class="px-3 py-2 text-gray-500">Tidak ada riwayat</div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <a href="{{ route('borrows.destroy', $borrow->id) }}"
                    class="px-2 py-1 bg-red-500 text-neutral-50 text-sm rounded-md w-full">Hapus Data</a>
            </div>
        </div>
    </div>
@endsection
