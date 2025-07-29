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

                <div class="">
                    <h3 class="text-xl text-neutral-700 font-bold">Daftar Koleksi Buku</h3>
                    <p class="text-xs text-neutral-500">Menu ini menampilkan daftar koleksi buku yang tersedia</p>
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
        <div class="mx-4">
            <table class="table font-sans w-full">
                <thead class="bg-teal-800 text-white text-sm sticky top-0 z-10">
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
                                        <p class="text-left">{{ Str::limit($book->clean_title, 50) }}</p>
                                    </form>

                                    {{-- Delete Book Button --}}
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-book-btn">
                                            <i data-lucide="trash-2" class="w-4 h-4 text-red-500"></i>
                                        </button>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $books->links() }}
        </div>
    </div>
@endsection
