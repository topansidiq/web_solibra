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
                        <i data-lucide="list" class="w-8 h-8 inline"></i>
                        <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                    </a>
                </div>

                <div class="">
                    <h3 class="text-xl text-neutral-700 font-bold">Daftar Peminjaman</h3>
                    <p class="text-xs text-neutral-500">Menu ini menampilkan daftar peminjaman yang tersedia</p>
                </div>
            </div>
            <div x-data="{ openAddborrowModal: false }">
                <!-- Tombol Buka Modal -->
                <div>
                    <button @click="openAddborrowModal = true"
                        class="flex flex-row bg-sky-800 text-white px-2 py-1 rounded-md hover:bg-sky-700 transition duration-200 gap-2">
                        <i data-lucide="plus" class="w-5 h-5"></i>
                        <span class="text-sm">Buat Peminjaman Baru</span>
                    </button>
                </div>

                <!-- Modal Tambah Peminjaman -->
                <div id="modalAddBorrow" x-show="openAddborrowModal" x-transition x-cloak
                    class="modal-add bg-white shadow-2xl rounded-lg fixed top-32 left-52 w-1/2 z-50">

                    <div class="bg-sky-800 w-full p-4 rounded-t-lg cursor-move modal-add-header">
                        <h2 class="text-xl font-bold flex items-center justify-between text-white">
                            <span>Buat Peminjaman Baru</span>
                            <button @click="openAddborrowModal = false">
                                <i class="block w-6 h-6 text-white text-sm cursor-pointer" data-lucide="x"></i>
                            </button>
                        </h2>
                    </div>

                    <form action="{{ route('borrows.store') }}" method="POST" class="grid grid-cols-2 gap-4 p-5 w-full">
                        @csrf

                        {{-- Select Book --}}
                        <div x-data="bookSearch({{ $books->sortByDesc('stock')->values()->toJson() }})" x-init="window.bookSearchInstance = $data" class="relative">
                            <label for keyword class="block font-semibold">Pilih Buku</label>
                            <input type="text" x-model="search" @focus="show = true" @keydown.tab.prevent="selectFirst()"
                                @keydown.enter.prevent="selectFirst()" @click.outside="show = false" id="keyword"
                                name="keyword" placeholder="Cari buku..."
                                class="form-input w-full border-b border-slate-400 focus:outline-0 p-2 placeholder:text-sm">

                            {{-- Dropdown --}}
                            <div x-show="show && filtered.length > 0"
                                class="absolute w-full bg-white shadow border mt-1 rounded z-50 max-h-60 overflow-y-auto">
                                <template x-for="(book, index) in filtered" :key="book.id">
                                    <div @click="select(book)" class="px-4 py-2 text-sm hover:bg-teal-100 cursor-pointer">
                                        <span x-text="book.title"></span>
                                        <span class="text-xs text-gray-500" x-text="'(' + book.stock + ' stock)'"></span>
                                    </div>
                                </template>
                            </div>

                            <input type="hidden" name="book_id" :value="book_id">
                        </div>

                        {{-- Select User --}}
                        <div x-data="userSearch({{ $users->values()->toJson() }})" x-init="window.userSearchInstance = $data" class="relative">
                            <label for keyword class="block font-semibold">Pilih Pengguna</label>
                            <input type="text" x-model="search" @focus="show = true" @keydown.tab.prevent="selectFirst()"
                                @keydown.enter.prevent="selectFirst()" @click.outside="show = false" id="keyword"
                                name="keyword" placeholder="Cari buku..."
                                class="form-input w-full border-b border-slate-400 focus:outline-0 p-2 placeholder:text-sm">

                            {{-- Dropdown --}}
                            <div x-show="show"
                                class="absolute w-full bg-white shadow border mt-1 rounded z-50 max-h-60 overflow-y-auto">
                                <template x-for="(user, index) in filtered" :key="user.id">
                                    <div @click="select(user)" class="px-4 py-2 text-sm hover:bg-teal-100 cursor-pointer">
                                        <span x-text="user.name"></span>
                                        <span class="text-xs text-gray-500" x-text="'(' + user.email + ')'"></span>
                                    </div>
                                </template>
                            </div>

                            <input class="text-xs" type="hidden" name="user_id" :value="user_id">
                        </div>

                        <div>
                            <label class="block font-semibold">Harus dikembalikan pada</label>
                            <input type="date" readonly value="{{ now()->addDays(14)->toDateString() }}">
                            <p class="text-sm text-gray-700 mt-1">
                                (otomatis 14 hari setelah tanggal konfirmasi peminjaman)
                            </p>
                        </div>

                        <!-- Tombol -->
                        <div class="col-span-2 pt-4 flex justify-end gap-4">
                            <button type="reset"
                                class="block rounded-sm font-bold bg-red-500 px-3 py-1 w-28 text-white hover:scale-105 transition-all">
                                Reset
                            </button>
                            <button type="button" @click="openAddborrowModal = false"
                                class="block rounded-sm font-bold bg-red-500 px-3 py-1 w-28 text-white hover:scale-105 transition-all">
                                Batal
                            </button>
                            <button type="submit"
                                class="bg-sky-800 px-3 py-1 rounded-sm font-bold text-white block w-28 hover:scale-105 transition-all">
                                Simpan
                            </button>
                        </div>
                    </form>
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
                        <th class="p-4">Nomor WhatsApp</th>
                        <th class="p-4 text-center">Tanggal Peminjaman</th>
                        <th class="p-4 text-center">Tanggal Pengembalian</th>
                        <th class="p-4 text-center">Status Peminjaman</th>
                        <th class="p-4 text-center">Perpanjangan</th>
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
                            <td class="px-4 py-1 border border-slate-300">
                                {{ $borrow->user->name ?? '-' }}
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-center" title="Hubungi">
                                {{ $borrow->user->phone_number ?? '-' }}
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ \Carbon\Carbon::parse($borrow->borrowed_at)->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                @if ($borrow->status === 'unconfirmed' || $borrow->status === 'archived')
                                    <span>-</span>
                                @elseif ($borrow->status === 'confirmed' || $borrow->status === 'extend')
                                    <span>Aktif</span>
                                @elseif ($borrow->status === 'returned')
                                    {{ Carbon\Carbon::parse($borrow->return_date)->translatedFormat('l, d-m-Y') }}
                                @endif
                            </td>

                            <td class="border border-slate-300 text-center">
                                @if ($borrow->user->member_status === 'new' || $borrow->user->member_status === 'active')
                                    <form action="{{ route('users.validation') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $borrow->user->id }}">
                                        <button type="submit"
                                            class="px-2 py-1 rounded-sm  bg-red-500 text-neutral-50 hover:bg-red-700 cursor-pointer">
                                            Belum Valid
                                        </button>
                                    </form>
                                @else
                                    @if ($borrow->status === 'unconfirmed')
                                        <form action="{{ route('borrows.confirm', $borrow->id) }}" method="POST"
                                            onsubmit="return confirm('Setujui peminjaman buku ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="book_id" value="{{ $borrow->book_id }}">
                                            <input type="hidden" name="user_id" value="{{ $borrow->user_id }}">
                                            <button class="flex items-center justify-between px-2" type="submit"
                                                title="Konfirmasi Peminjaman">
                                                <i data-lucide="check" class="w-5 h-5 text-green-500"></i>
                                                <span class="block px-2">
                                                    Peminjaman Belum Dikonfirmasi
                                                </span>
                                            </button>
                                        </form>
                                    @elseif ($borrow->status === 'confirmed')
                                        <form action="{{ route('borrows.return', $borrow->id) }}" method="POST"
                                            onsubmit="return confirm('Kembalikan sekarang??')">
                                            @csrf
                                            @method('PATCH')
                                            <button class="flex items-center justify-between px-2" type="submit"
                                                title="Konfirmasi Pengembalian">
                                                <i data-lucide="undo-2" class="w-5 h-5 text-blue-500"></i>
                                                <span class="block px-2">
                                                    Peminjaman Aktif
                                                </span>
                                            </button>
                                        </form>
                                    @elseif ($borrow->status === 'returned')
                                        <form action="{{ route('borrows.archive', $borrow->id) }}" method="POST"
                                            onsubmit="return confirm('Arsipkan peminjaman ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button class="flex items-center justify-between px-2" type="submit"
                                                title="Arsipkan Peminjaman">
                                                <i data-lucide="archive" class="w-5 h-5 "></i>
                                                <span class="block px-2">
                                                    Dikembalikan
                                                </span>
                                            </button>
                                        </form>
                                    @elseif ($borrow->status === 'overdue')
                                        <form action="{{ route('borrows.overdue', $borrow->id) }}" method="POST"
                                            onsubmit="return confirm('Konfirmasi pengembalian?')">
                                            @csrf
                                            @method('PATCH')
                                            <button class="flex items-center justify-between px-2" type="submit">
                                                <i data-lucide="bell" class="w-5 h-5 text-yellow-500"></i>
                                                <span class="block px-2">
                                                    Jatuh Tempo
                                                </span>
                                            </button>
                                        </form>
                                    @elseif ($borrow->status === 'extend')
                                        <form action="{{ route('borrows.return', $borrow->id) }}" method="POST"
                                            onsubmit="return confirm('Kembalikan sekarang??')">
                                            @csrf
                                            @method('PATCH')
                                            <button class="flex items-center justify-between px-2" type="submit"
                                                title="Konfirmasi Pengembalian">
                                                <i data-lucide="undo-2" class="w-5 h-5 text-blue-500"></i>
                                                <span class="block px-2">
                                                    Diperpanjang
                                                </span>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                                {{-- Tombol Konfirmasi Peminjaman --}}

                            </td>
                            <td class="border border-slate-300 text-center">
                                {{-- Tombol Konfirmasi Perpanjangan --}}
                                @if ($borrow->status === 'confirmed' || $borrow->status === 'extend')
                                    <form action="{{ route('borrows.extend', $borrow->id) }}" method="POST"
                                        onsubmit="return confirm('Konfirmasi Perpanjangan??')">
                                        @csrf
                                        <input type="hidden" name="borrow_id" value="{{ $borrow->id }}">
                                        <input type="hidden" name="book_id" value="{{ $borrow->book_id }}">
                                        <input type="hidden" name="user_id" value="{{ $borrow->user_id }}">
                                        <input type="hidden" name="borrowed_at" value="{{ $borrow->borrowed_at }}">
                                        <button class="flex items-center justify-between px-2" type="submit"
                                            title="Konfirmasi Perpanjangan">
                                            <i data-lucide="repeat" class="w-5 h-5 text-blue-500"></i>
                                            @if ($borrow->extend === 3)
                                                <span class="block px-2 text-red-500">
                                                    Perpanjangan {{ $borrow->extend }} dari 3
                                                </span>
                                            @else
                                                <span class="block px-2">
                                                    Perpanjangan {{ $borrow->extend }} dari 3
                                                </span>
                                            @endif
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $borrows->links() }}
        </div>
    </div>
@endsection
