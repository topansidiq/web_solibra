@extends('admin.layouts.app')

@section('content')
    <div class="content flex flex-col flex-auto bg-gray-50 w-full" x-data="{ openAddBookModal: false }">
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
                        <i data-lucide="home" class="w-8 h-8 inline"></i>
                        <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                    </a>
                </div>

                <div class="">
                    <h3 class="text-xl text-neutral-700 font-bold">Daftar Koleksi Buku</h3>
                    <p class="text-xs text-neutral-500">Menu ini menampilkan daftar koleksi buku yang tersedia</p>
                </div>
            </div>

            {{-- Action --}}
            <div class="flex gap-4">
                {{-- Filter --}}

                {{-- Search --}}
                <form method="GET" action="{{ route('books.index') }}" class="flex items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul/penulis..."
                        class="flex flex-row items-center justify-around rounded-md cursor-pointer text-xs px-2 py-1 bg-sky-700 text-neutral-200 gap-2 w-2xs" />
                    <button type="submit" class="px-2 py-1 bg-sky-600 text-white rounded-md text-xs">Cari</button>
                </form>

                {{-- Category Filter --}}
                <form method="GET" class="flex items-center gap-2">
                    <label for="category" class="text-sm font-medium text-gray-700">Filter:</label>

                    <div class="relative">
                        <select name="category" id="category" onchange="this.form.submit()"
                            class="appearance-none bg-sky-700 text-slate-200 text-xs px-3 py-1 pr-8 rounded-md cursor-pointer shadow-sm">
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
                <a href="{{ route('books.create') }}"
                    class="flex flex-row items-center justify-around rounded-md cursor-pointer px-2 py-1 bg-sky-700 text-neutral-200 gap-2">
                    <i data-lucide="plus" class="block w-4 h-4"></i>
                    <p class="text-xs">Tambah Buku</p>
                </a>
            </div>
        </div>

        {{-- Tabel Scrollable --}}
        <div class="mx-4 h-screen overflow-scroll">
            <table class="table font-sans w-full">
                <thead class="bg-sky-800 text-white text-sm sticky top-0 z-10">
                    @php
                        $columns = [
                            ['key' => null, 'label' => 'No.'],
                            ['key' => 'title', 'label' => 'Judul'],
                            ['key' => 'author', 'label' => 'Penulis'],
                            ['key' => 'publisher', 'label' => 'Penerbit'],
                            ['key' => 'year', 'label' => 'Tahun'],
                            ['key' => 'isbn', 'label' => 'ISBN'],
                            ['key' => null, 'label' => 'Kategori'],
                            ['key' => 'stock', 'label' => 'Stok'],
                            ['key' => 'aksi', 'label' => 'aksi'],
                        ];
                    @endphp

                    <tr>
                        @foreach ($columns as $col)
                            <th class="p-4 {{ $col['key'] ? '' : 'text-center' }}">
                                {{ $col['label'] }}
                            </th>
                        @endforeach
                    </tr>

                </thead>
                <tbody class="text-xs">
                    @foreach ($books as $index => $book)
                        <tr>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-4 py-1 border border-slate-300">
                                <div class="flex flex-row gap-2 justify-between items-center">
                                    <form class="flex items-center gap-2">
                                        {{-- Book Title --}}
                                        <p class="text-left">{{ Str::limit($book->clean_title, 50) }}</p>
                                    </form>
                                </div>
                            </td>
                            <td class="px-4 py-1 border border-slate-300">{{ $book->formatted_author }}</td>
                            <td class="px-4 py-1 border border-slate-300">
                                {{ preg_replace('/[:,]/', '', $book->publisher) }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center">{{ $book->year }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ preg_replace('/[-]/', '', $book->isbn) }}</td>
                            <td class="px-4 py-1 border border-slate-300">
                                <span class="badge">
                                    {{ $book->categories->take(3)->pluck('name')->implode(', ') }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border border-slate-300 text-center">{{ $book->stock }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center w-32">
                                <div class="flex items-center justify-center gap-1">
                                    {{-- <a href="{{ route('books.show', $user->id) }}"
                                        class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1 rounded">
                                        Detail
                                    </a> --}}

                                    <a href="{{ route('books.edit', $book->id) }}"
                                        class="bg-sky-800 hover:bg-sky-900 text-white text-xs px-3 py-1 rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus buku ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded flex items-center justify-center h-[25px]">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                    {{-- Delete Book Button --}}
                                    {{-- <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-book-btn">
                                            <i data-lucide="trash-2" class="w-4 h-4 text-red-500"></i>
                                        </button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @php
                $totalPages = ceil($totalBooks / $perPage);
            @endphp

            @if ($totalPages > 1)
                <div class="mt-4 flex flex-wrap gap-2 text-xs">
                    @for ($i = 1; $i <= $totalPages; $i++)
                        <a href="{{ route('books.index', ['page' => $i]) }}"
                            class="px-3 py-1 rounded border
                            {{ $i == $currentPage ? 'bg-sky-700 text-white' : 'bg-white text-gray-800' }}">
                            {{ $i }}
                        </a>
                    @endfor
                </div>
            @endif

        </div>
    </div>
@endsection
