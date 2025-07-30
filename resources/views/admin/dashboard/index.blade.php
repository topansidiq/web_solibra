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

                {{-- Add new user button --}}
                {{-- Add new event button --}}
                {{-- Add new post button --}}

            </div>

        </div>

        {{-- New Book --}}
        <div class="mx-4 p-4 shadow rounded-xl bg-white text-sm text-slate-800 w-auto h-fit">
            <div>
                <h2 class="text-lg text-neutral-700 font-bold">Buku Terbaru</h2>
                <p class="text-xs text-neutral-500">6 buku terbaru ditambahkan</p>
            </div>

            <div class="py-2 grid xl:grid-cols-6 gap-2 sm:grid-cols-3" x-data="{ open: false, book: {} }" x-ref="modal">
                @forelse ($latestBooks as $book)
                    <div class="border border-slate-200 p-4 book cursor-pointer hover:shadow-md transition"
                        @click="open = true; book = {{ json_encode([
                            'title' => $book->title,
                            'author' => $book->author,
                            'publisher' => $book->publisher,
                            'publication_place' => $book->publication_place,
                            'pages' => $book->pages,
                            'year' => $book->year,
                            'isbn' => $book->isbn,
                            'stock' => $book->stock,
                            'description' => $book->description,
                            'cover' => $book->cover ? asset('storage/' . $book->cover) : '',
                            'initial' => $book->initial,
                            'categories' => $book->categories->pluck('name')->join(', '),
                            'created_at' => $book->created_at->format('d M Y'),
                        ]) }}">
                        <div
                            class="xl:h-70 sm:h-40 bg-gradient-to-bl from-sky-700 to-sky-400 text-white flex items-center justify-center rounded shadow text-3xl font-bold">
                            @if ($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}"
                                    class="w-full h-full object-cover rounded-xl">
                            @else
                                {{ $book->initial }}
                            @endif
                        </div>
                        <div class="pt-2">
                            <strong>{{ $book->title }} ({{ $book->year }})</strong><br>
                            <p class="text-xs">Penulis: {{ $book->author }} </p>
                            <span class="text-xs text-slate-500">Ditambahkan pada
                                {{ $book->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <li>Tidak ada buku terbaru.</li>
                @endforelse

                {{-- Modal --}}
                <div x-show="open" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
                    style="display: none;">
                    <div class="bg-white p-6 rounded-lg w-11/12 md:w-1/2 relative" @click.away="open = false">
                        <!-- Tombol Tutup -->
                        <button class="absolute top-4 right-4 text-slate-500 hover:text-red-500" @click="open = false">
                            <i data-lucide="x"></i>
                        </button>

                        <!-- Judul dan Penulis -->
                        <div class="flex flex-col mb-4">
                            <h2 class="text-xl font-semibold" x-text="book.title"></h2>
                            <span class="text-xs text-slate-600" x-text="book.author"></span>
                        </div>

                        <!-- Cover atau Inisial -->
                        <template x-if="book.cover">
                            <img :src="book.cover" alt="Book Cover" class="w-full h-64 object-cover rounded mb-4" />
                        </template>
                        <template x-if="!book.cover">
                            <div class="w-full h-64 bg-gradient-to-bl from-sky-700 to-sky-400 text-white flex items-center justify-center rounded text-5xl font-bold mb-4"
                                x-text="book.initial"></div>
                        </template>

                        <!-- Info Buku -->
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div>
                                <strong>Penerbit</strong>
                                <span class="block text-xs text-slate-700" x-text="book.publisher"></span>
                            </div>
                            <div>
                                <strong>Bahasa</strong>
                                <span class="block text-xs text-slate-700" x-text="book.language"></span>
                            </div>
                            <div>
                                <strong>Halaman</strong>
                                <span class="block text-xs text-slate-700" x-text="book.pages"></span>
                            </div>
                            <div>
                                <strong>Tahun</strong>
                                <span class="block text-xs text-slate-700" x-text="book.year"></span>
                            </div>
                            <div>
                                <strong>ISBN</strong>
                                <span class="block text-xs text-slate-700" x-text="book.isbn"></span>
                            </div>
                            <div>
                                <strong>Stok</strong>
                                <span class="block text-xs text-slate-700" x-text="book.stock"></span>
                            </div>
                            <div>
                                <strong>Kategori</strong>
                                <span class="block text-xs text-slate-700" x-text="book.categories"></span>
                            </div>
                            <div>
                                <strong>Ditambahkan</strong>
                                <span class="block text-xs text-slate-700" x-text="book.created_at"></span>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4 text-sm">
                            <h3 class="font-bold mb-1">Deskripsi</h3>
                            <p class="text-xs text-slate-700" x-text="book.description"></p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        {{-- Activity --}}
        <div class="ml-4 p-4 shadow rounded-xl bg-white text-sm text-slate-800 w-fit h-fit mt-2">
            <h2 class="text-lg font-bold">Aktivitas</h2>
            <div class="py-2 grid grid-cols-6 gap-2">
                <div class="border border-slate-200 w-60 h-60 content-center text-center p-10 rounded-xl">
                    <h3>Total Buku</h3>
                    <p class="text-6xl font-bold">{{ $books_count }}</p>
                </div>
                <div class="border border-slate-200 w-60 h-60 content-center text-center p-10 rounded-xl">
                    <h3>Total Kategori</h3>
                    <p class="text-6xl font-bold">{{ $categories_count }}</p>
                </div>
                <div class="border border-slate-200 w-60 h-60 content-center text-center p-10 rounded-xl">
                    <h3>Total Buku Dipinjam</h3>
                    <p class="text-6xl font-bold">{{ $borrows_count }}</p>
                </div>
                <div class="border border-slate-200 w-60 h-60 content-center text-center p-10 rounded-xl">
                    <h3>Total Pengguna Terdaftar</h3>
                    <p class="text-6xl font-bold">{{ $users_count }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
