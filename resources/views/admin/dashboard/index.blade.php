@extends('admin.layouts.app')

@section('content')
    <div class="content flex flex-col flex-auto bg-sky-50 w-full">

        {{-- Page Header --}}
        <div class="title p-4 flex items-center justify-between">

            {{-- Title --}}
            <div class="">
                <h3 class="text-xl text-neutral-700 font-bold">Beranda</h3>
                <p class="text-xs text-neutral-500">Menu ini menampilkan aktifitas di dalam aplikasi.</p>
            </div>

            {{-- Action --}}
            <div class="flex flex-row gap-3">

                {{-- Add new book button --}}
                <div
                    class="flex items-center justify-around rounded-sm cursor-pointer px-2 py-1 bg-sky-700 text-xs text-neutral-50">
                    <a href="{{ route('books.create') }}" class="flex items-center">
                        <i data-lucide="plus" class="block w-4 h-4"></i>
                        <p>Tambah Buku</p>
                    </a>
                </div>

                {{-- Add new category button --}}
                <div x-data="{ open: false }">
                    <div @click="open = true"
                        class="flex flex-row items-center justify-around cursor-pointer rounded-md px-2 py-1 bg-sky-700 text-neutral-50 text-xs">
                        <i data-lucide="plus" class="block w-4 h-4"></i>
                        <p>Tambah Kategori</p>
                    </div>

                    <div x-cloak x-transition
                        class="modal-add bg-neutral-50 shadow-2xl rounded-lg fixed top-32 left-52 w-1/3" x-show="open">
                        <div class="bg-sky-950 p-4 rounded-t-lg cursor-move modal-add-header">
                            <h2 class="flex align-middle justify-between">
                                <div>
                                    <p class="text-xl font-semibold text-neutral-100">Tambah Kategori Baru</p>
                                    <p class="text-xs text-neutral-300">Menu untuk menambah kategori baru untuk sebuah
                                        koleksi</p>
                                </div>
                                <button @click="open=false"><i class="block w-6 h-6 text-white text-sm cursor-pointer"
                                        data-lucide="x"></i></button>
                            </h2>
                        </div>

                        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
                            class="grid grid-cols-2 gap-4 p-5 w-full">
                            @csrf

                            <div>
                                <label for="name" class="block font-semibold">Kategori</label>
                                <input type="text" name="name" id="name"
                                    class="form-input w-full border-b border-neutral-300 focus: outline-0 p-2 placeholder: text-sm"
                                    placeholder="Masukkan kategori baru..." required>
                            </div>

                            <div class="col-span-2 pt-4 flex flex-row content-end gap-4 justify-end-safe">
                                <button @click="open = false"
                                    class="block rounded-sm font-bold bg-red-700 px-3 py-1 w-28 text-white hover:scale-105 transition-all">Batal</button>
                                <button type="submit"
                                    class="bg-sky-700 px-3 py-1 rounded-sm font-bold text-white block w-28 hover:scale-105 transition-all">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

                {{-- Add new borrow button --}}
                <div x-data="{ open: false }">
                    <div @click="open = true"
                        class="flex flex-row items-center justify-around cursor-pointer rounded-md px-2 py-1 bg-sky-700 text-neutral-200">
                        <i data-lucide="plus" class="block w-4 h-4"></i>
                        <p class="text-xs">Tambah Peminjaman</p>
                    </div>

                    <div x-cloak x-transition class="modal-add bg-white shadow-2xl rounded-lg fixed top-32 left-52 w-fit"
                        x-show="open">
                        <div class="bg-sky-950 w-full p-4 rounded-t-lg cursor-move modal-add-header">
                            <h2 class="flex align-middle justify-between">
                                <div>
                                    <p class="text-xl font-semibold text-neutral-100">Tambah Peminjaman Baru</p>
                                    <p class="text-xs text-neutral-300">Menu untuk membuat peminjaman buku/koleksi</p>
                                </div>
                                <button @click="open=false"><i class="block w-6 h-6 text-white text-sm cursor-pointer"
                                        data-lucide="x"></i></button>
                            </h2>
                        </div>

                        <form action="{{ route('borrows.store') }}" method="POST"
                        class="grid grid-cols-2 gap-4 p-5 w-full">
                            @csrf

                            {{-- Select Book --}}
                            <div x-data="bookSearch({{ $books->sortByDesc('stock')->values()->toJson() }})" x-init="window.bookSearchInstance = $data" class="relative">
                                <label for keyword class="block font-semibold">Pilih Buku</label>
                                <input type="text" x-model="search" @focus="show = true"
                                    @keydown.tab.prevent="selectFirst()" @keydown.enter.prevent="selectFirst()"
                                    @click.outside="show = false" id="keyword" name="keyword" placeholder="Cari buku..."
                                    class="form-input w-full border-b border-neutral-300 focus:outline-0 p-2 placeholder:text-sm">

                                {{-- Dropdown --}}
                                <div x-show="show && filtered.length > 0"
                                    class="absolute w-full bg-white shadow border mt-1 rounded z-50 max-h-60 overflow-y-auto">
                                    <template x-for="(book, index) in filtered" :key="book.id">
                                        <div @click="select(book)"
                                            class="px-4 py-2 text-sm hover:bg-teal-100 cursor-pointer">
                                            <span x-text="book.title"></span>
                                            <span class="text-xs text-neutral-500"
                                                x-text="'(' + book.stock + ' stock)'"></span>
                                        </div>
                                    </template>
                                </div>

                                <input type="hidden" name="book_id" :value="book_id">
                            </div>

                            {{-- Select User --}}
                            <div x-data="userSearch({{ $users->values()->toJson() }})" x-init="window.userSearchInstance = $data" class="relative">
                                <label for keyword class="block font-semibold">Pilih Pengguna</label>
                                <input type="text" x-model="search" @focus="show = true"
                                    @keydown.tab.prevent="selectFirst()" @keydown.enter.prevent="selectFirst()"
                                    @click.outside="show = false" id="keyword" name="keyword" placeholder="Cari buku..."
                                    class="form-input w-full border-b border-neutral-300 focus:outline-0 p-2 placeholder:text-sm">

                                {{-- Dropdown --}}
                                <div x-show="show"
                                    class="absolute w-full bg-white shadow border mt-1 rounded z-50 max-h-60 overflow-y-auto">
                                    <template x-for="(user, index) in filtered" :key="user.id">
                                        <div @click="select(user)"
                                            class="px-4 py-2 text-sm hover:bg-teal-100 cursor-pointer">
                                            <span x-text="user.name"></span>
                                            <span class="text-xs text-neutral-500" x-text="'(' + user.email + ')'"></span>
                                        </div>
                                    </template>
                                </div>

                                <input class="text-xs" type="hidden" name="user_id" :value="user_id">
                            </div>

                            <!-- Tanggal Pengembalian -->
                            @php
                                $dueDate = now()->addDays(7)->locale('id')->translatedFormat('d F Y');
                            @endphp

                            <div>
                                <label class="block font-semibold">Harus dikembalikan pada</label>
                                <input type="date" readonly name="due_date"
                                value="{{ now()->addDays(7)->toDateString() }}">
                                <p class="text-sm text-neutral-700 mt-1">
                                    (otomatis 7 hari setelah tanggal peminjaman)
                                </p>
                            </div>

                            <input type="hidden" name="borrowed_at" value="{{ now()->toDateString() }}">

                            <!-- Tombol -->
                            <div class="col-span-2 pt-4 flex justify-end gap-4">
                                <button type="reset"
                                    class="block rounded-sm font-bold bg-red-700 px-3 py-1 w-28 text-white hover:scale-105 transition-all">
                                    Reset
                                </button>
                                <button type="button" @click="openAddborrowModal = false"
                                    class="block rounded-sm font-bold bg-red-700 px-3 py-1 w-28 text-white hover:scale-105 transition-all">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-sky-700 px-3 py-1 rounded-sm font-bold text-white block w-28 hover:scale-105 transition-all">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>

        {{-- Activity (Overview Cards) --}}
        <div class="ml-4 p-4 shadow rounded-xl bg-white text-sm text-slate-800 w-auto mt-2">
            <h2 class="text-lg font-bold mb-4">Aktivitas</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div
                    class="border border-slate-200 flex flex-col items-center justify-center h-40 rounded-xl shadow-sm bg-slate-50">
                    <h3 class="text-base font-semibold text-slate-600">Total Buku</h3>
                    <p class="text-4xl font-bold mt-2">{{ $books_count }}</p>
                </div>
                <div
                    class="border border-slate-200 flex flex-col items-center justify-center h-40 rounded-xl shadow-sm bg-slate-50">
                    <h3 class="text-base font-semibold text-slate-600">Total Kategori</h3>
                    <p class="text-4xl font-bold mt-2">{{ $categories_count }}</p>
                </div>
                <div
                    class="border border-slate-200 flex flex-col items-center justify-center h-40 rounded-xl shadow-sm bg-slate-50">
                    <h3 class="text-base font-semibold text-slate-600">Total Buku Dipinjam</h3>
                    <p class="text-4xl font-bold mt-2">{{ $borrows_count }}</p>
                </div>
                <div
                    class="border border-slate-200 flex flex-col items-center justify-center h-40 rounded-xl shadow-sm bg-slate-50">
                    <h3 class="text-base font-semibold text-slate-600">Total Pengguna Terdaftar</h3>
                    <p class="text-4xl font-bold mt-2">{{ $users_count }}</p>
                </div>
            </div>
        </div>

        {{-- Laporan Grafik --}}
        <div class="ml-4 p-4 shadow rounded-xl bg-white text-sm text-slate-800 w-auto mt-4">
            <h2 class="text-lg font-bold mb-4">Laporan Grafik</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 border border-slate-200 rounded-xl shadow-sm bg-slate-50">
                    <h3 class="text-base font-semibold mb-2 text-slate-700">Laporan Peminjaman Buku</h3>
                    <canvas id="borrowChart" class="w-full h-64"></canvas>
                </div>

                <div class="p-4 border border-slate-200 rounded-xl shadow-sm bg-slate-50">
                    <h3 class="text-base font-semibold mb-2 text-slate-700"> Laporan Keterlambatan </h3>
                    <canvas id="overdueChart" class="w-full h-64"></canvas>
                </div>
            </div>
        </div>

        {{-- ChartJS --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const labels = @json($months);

            // Chart Peminjaman
            const borrowData = {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: @json($borrowData),
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: 'blue',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            };

            new Chart(document.getElementById('borrowChart'), {
                type: 'line',
                data: borrowData,
                options: {
                    responsive: true,
                    animation: false,
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Chart Overdue
            const overdueData = {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Overdue',
                    data: @json($overdueData),
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: 'red',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            };

            new Chart(document.getElementById('overdueChart'), {
                type: 'line',
                data: overdueData,
                options: {
                    responsive: true,
                    animation: false,
                    scales: { y: { beginAtZero: true } }
                }
            });
        </script>
    </div>
@endsection
