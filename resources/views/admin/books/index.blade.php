@extends('admin.layouts.app')

@section('content')
    <div class="content flex flex-col flex-auto bg-gray-50 w-full" x-data="{ openAddBookModal: false }">
        <div class="title p-4 flex flex-row items-center justify-between">

            {{-- Header/Page Title/Page Description --}}
            <div class="flex flex-row gap-2">
                {{-- Go to Dashboard --}}
                <div class="flex items-center w-fit">
                    <a href="{{ route('dashboard.index') }}" class="text-teal-950 font-bold">
                        <i data-lucide="home" class="w-8 h-8 inline"></i>
                        <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                    </a>
                </div>

                <div>
                    <h3 class="text-xl font-bold">Daftar Koleksi</h3>
                    <p class="text-sm">Ini adalah daftar koleksi buku yang tersedia di perpustakaan</p>
                </div>
            </div>

            {{-- Action --}}
            <div class="flex gap-4">
                {{-- Filter --}}

                {{-- Category Filter --}}
                <form method="GET" class="flex items-center gap-2">
                    <label for="category" class="text-sm font-medium text-gray-700">Filter:</label>

                    <div class="relative">
                        <select name="category" id="category" onchange="this.form.submit()"
                            class="appearance-none bg-teal-950 text-slate-200 text-sm px-3 py-1 pr-8 rounded-md cursor-pointer shadow-sm">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-300"></i>
                        </div>
                    </div>
                </form>
                <button type="button" @click="openAddBookModal = true"
                    class="flex flex-row items-center justify-around rounded-md cursor-pointer px-2 py-1 bg-teal-950 text-slate-200">
                    <i data-lucide="plus" class="block w-5 h-5"></i>
                    <p class="text-sm">Tambah Buku</p>
                </button>
                {{-- Modal Tambah Buku --}}
                <div class="modal-add bg-white shadow-2xl rounded-lg fixed top-32 left-52 w-1/2 z-50" x-cloak
                    x-show="openAddBookModal">
                    <div class="bg-teal-950 w-full p-4 rounded-t-lg cursor-move modal-add-header">
                        <h2 class="text-xl font-bold flex align-middle justify-between">
                            <span class="block text-white">Tambah Buku Baru</span>
                            <button type="button" @click="openAddBookModal=false"><i
                                    class="block w-6 h-6 text-white text-sm cursor-pointer" data-lucide="x"></i></button>
                        </h2>
                    </div>

                    <form id="modal" action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data"
                        class="grid grid-cols-2 gap-4 p-5 w-full">
                        @csrf

                        <input type="hidden" name="_method" id="formMethod" value="POST">


                        <div>
                            <label for="title-edit" class="block font-semibold">Judul Buku</label>
                            <input type="text" name="title" id="title-edit"
                                class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                                placeholder="Contoh: Pemrograman Web" required>
                        </div>

                        <div>
                            <label for="author-edit" class="block font-semibold">Penulis</label>
                            <input type="text" name="author" id="author-edit"
                                class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                                required placeholder="Contoh: Rio, Andi, Rahmat">
                        </div>

                        <div>
                            <label for="publisher-edit" class="block font-semibold">Penerbit</label>
                            <input type="text" name="publisher" id="publisher-edit"
                                class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                                placeholder="Contoh: Solok Publisher">
                        </div>
                        <div>
                            <label for="language-edit" class="block font-semibold">Bahasa</label>
                            <input type="text" name="language" id="language-edit"
                                class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                                placeholder="Contoh: Indonesia">
                        </div>
                        <div>
                            <label for="pages-edit" class="block font-semibold">Halaman</label>
                            <input type="number" name="pages" id="pages-edit"
                                class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                                placeholder="Contoh: 991">
                        </div>

                        <div>
                            <label for="year-edit" class="block font-semibold">Tahun</label>
                            <input type="number" name="year" id="year-edit"
                                class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                                min="1900" max="{{ date('Y') }}" placeholder="Contoh: 1998">
                        </div>

                        <div>
                            <label for="isbn-edit" class="block font-semibold">ISBN</label>
                            <input type="text" name="isbn" id="isbn-edit"
                                class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                                placeholder="Contoh: 987654321">
                        </div>

                        <div id="selectedCategories">
                            <div x-data="categorySearch({{ $categories->sortByDesc('books_count')->values()->toJson() }})" x-init="window.categorySearchInstance = $data" class="relative">
                                <label for="keyword" class="block font-semibold">Kategori</label>
                                <input type="text" x-model="search" @focus="show = true"
                                    @keydown.tab.prevent="selectFirst()" @keydown.enter.prevent="selectFirst()"
                                    @click.outside="show = false" id="keyword" name="keyword"
                                    class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                                    placeholder="Ketikkan kategori...">

                                <!-- Dropdown kategori -->
                                <div x-show="show"
                                    class="absolute w-full bg-white shadow border mt-1 rounded z-50 max-h-60 overflow-y-auto">
                                    <template x-for="(cat, index) in filtered" :key="cat.id">
                                        <div @click="select(cat)"
                                            class="px-4 py-2 text-sm hover:bg-teal-100 cursor-pointer"
                                            :class="index === 0 ? 'bg-teal-50' :
                                                ''">
                                            <span x-text="cat.name"></span>
                                            <span class="text-xs text-gray-400"
                                                x-text="'(' + cat.books_count + ' buku)'"></span>
                                        </div>
                                    </template>

                                    <template x-if="filtered.length === 0">
                                        <div class="px-4 py-2 text-sm text-gray-400">Tidak ditemukan</div>
                                    </template>
                                </div>

                                <!-- Tampilkan kategori yang dipilih -->
                                <div class="mt-2 flex flex-wrap gap-1" id="categories">
                                    <template x-for="(cat, i) in selected" :key="cat.id">
                                        <div class="bg-teal-100 text-teal-800 px-2 py-1 rounded text-sm flex items-center">
                                            <span x-text="cat.name"></span>
                                            <button type="button" class="ml-2" @click="remove(cat.id)">
                                                x
                                            </button>
                                            <input type="hidden" name="categories[]" :value="cat.id">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="stock-edit" class="block font-semibold">Stok</label>
                            <input type="number" name="stock" id="stock-edit"
                                class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                                min="0" placeholder="Contoh: 23">
                        </div>

                        <div>
                            <label for="cover-edit" class="block font-semibold">Cover Buku</label>
                            <input type="file" name="cover" id="cover-edit"
                                class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm">
                        </div>

                        <div class="col-span-2">
                            <label for="description" class="block font-semibold">Deskripsi</label>
                            <textarea name="description" id="description-edit" rows="5"
                                placeholder="Bagian ini bisa di isi dengan sinopsis atau abstrak"
                                class="form-textarea text-sm w-full border-b border-slate-400 focus: outline-0 placeholder:text-sm placeholder:text-center resize-y"></textarea>
                        </div>

                        <div class="col-span-2 pt-4 flex flex-row content-end gap-4 justify-end-safe">
                            <button type="reset" id="resetBtn"
                                class="block rounded-sm font-bold bg-red-500 px-3 py-1 w-28 text-white hover:scale-105 transition-all">Reset</button>
                            <button type="button" @click="openAddBookModal=false"
                                class="block rounded-sm font-bold bg-red-500 px-3 py-1 w-28 text-white hover:scale-105 transition-all">Batal</button>
                            <button type="submit"
                                class="bg-emerald-700 px-3 py-1 rounded-sm font-bold text-white block w-28 hover:scale-105 transition-all">
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
                <thead class="bg-teal-800 text-white text-sm sticky top-0 z-10">
                    @php
                        $columns = [
                            ['key' => null, 'label' => 'No.'],
                            ['key' => 'title', 'label' => 'Judul'],
                            ['key' => 'author', 'label' => 'Penulis'],
                            ['key' => 'publisher', 'label' => 'Penerbit'],
                            ['key' => null, 'label' => 'Bahasa'],
                            ['key' => null, 'label' => 'Halaman'],
                            ['key' => 'year', 'label' => 'Tahun'],
                            ['key' => 'isbn', 'label' => 'ISBN'],
                            ['key' => null, 'label' => 'Kategori'],
                            ['key' => 'stock', 'label' => 'Stok'],
                        ];
                    @endphp

                    <tr>
                        @foreach ($columns as $col)
                            <th class="p-4 {{ $col['key'] ? '' : 'text-center' }}">
                                @if ($col['key'])
                                    <a href="{{ route('books.index', [
                                        'sort_by' => $col['key'],
                                        'sort_dir' => $sortBy === $col['key'] && $sortDir === 'asc' ? 'desc' : 'asc',
                                    ]) }}"
                                        class="hover:underline">
                                        {{ $col['label'] }}
                                        @if ($sortBy === $col['key'])
                                            <i data-lucide="{{ $sortDir === 'asc' ? 'arrow-up' : 'arrow-down' }}"
                                                class="w-4 h-4 inline"></i>
                                        @endif
                                    </a>
                                @else
                                    {{ $col['label'] }}
                                @endif
                            </th>
                        @endforeach
                    </tr>

                </thead>
                <tbody class="text-xs">
                    @foreach ($books as $book)
                        <tr>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}
                            </td>

                            <td class="px-4 py-1 border border-slate-300">
                                <div class="flex flex-row gap-2 justify-between items-center">
                                    <form class="flex items-center gap-2">
                                        {{-- Edit Book Button --}}
                                        <a href="{{ route('books.edit', $book->id) }}" class="block">
                                            <i data-lucide="edit" class="w-4 h-4 text-blue-500"></i>
                                        </a>

                                        {{-- Book Title --}}
                                        <p class="text-left">{{ $book->title }}</p>
                                    </form>

                                    {{-- Delete Book Button --}}
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                        class="ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-book-btn">
                                            <i data-lucide="trash-2" class="w-4 h-4 text-red-500"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                            <td class="px-4 py-1 border border-slate-300">{{ $book->author }}</td>
                            <td class="px-4 py-1 border border-slate-300">{{ $book->publisher }}</td>
                            <td class="px-4 py-1 border border-slate-300">{{ $book->language }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center">{{ $book->pages }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center">{{ $book->year }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center">{{ $book->isbn }}</td>
                            <td class="px-4 py-1 border border-slate-300">
                                @foreach ($book->categories->take(3) as $category)
                                    <span class="badge">{{ $category->name }},</span>
                                @endforeach
                            </td>
                            <td class="px-4 py-2 border border-slate-300 text-center">{{ $book->stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $books->links() }}
        </div>
    </div>
@endsection
