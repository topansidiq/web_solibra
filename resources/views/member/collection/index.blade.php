@extends('member.layouts.app')

@section('content')
    <div>
        <div>
            <div class="max-w-7xl flex bg-gray-50 gap-4 p-4 mx-auto items-center justify-between">
                <p class="font-bold text-lg text-slate-800">Daftar Koleksi Buku</p>
                <!-- Filter Kategori -->
                <div class="flex items-center gap-3">
                    <h3 class="text-sm">Filter Kategori:</h3>
                    <div class="flex gap-3">
                        <a href="{{ route('member.collection') }}"
                            class="hover:bg-slate-500 hover:text-teal-500 {{ !$selectedCategory ? 'bg-teal-600 text-white' : 'bg-teal-200 text-gray-700 hover:bg-gray-300' }}">
                            Semua
                        </a>
                        @foreach ($categories as $category)
                            <a href="{{ route('member.collection', ['category' => $category->id]) }}"
                                class="px-4 py-2 rounded-full border text-sm font-medium
                          {{ $selectedCategory == $category->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
            <div class="max-w-7xl bg-gray-50 gap-4 p-4 grid grid-cols-6 mx-auto content-around">
                @foreach ($books as $book)
                    <div
                        class="book bg-slate-50 rounded shadow border border-slate-300 cursor-pointer hover:scale-105 transition">
                        <div class="h-50 bg-slate-400">
                            <img src="/storage/covers/{{ $book->cover }}" alt="" class="">
                        </div>

                        <div class="p-2">
                            <h2 class="font-bold text-sm">{{ $book->title }} ({{ $book->year }})</h2>
                            <div class="text-xs">
                                @foreach ($book->categories as $category)
                                    <span class="">{{ $category->name }}, </span>
                                @endforeach
                            </div>
                            <p class="text-xs font-semibold text-slate-500">Penulis: {{ $book->author }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div>
            <div class="max-w-7xl flex bg-gray-50 gap-4 p-4 mx-auto items-center justify-between">
                <p class="font-bold text-lg text-slate-800">Daftar Pinjaman Kamu</p>
            </div>
            <div class="max-w-7xl bg-gray-50 gap-4 p-4 grid grid-cols-6 mx-auto content-around">
                @if ($collections->isEmpty())
                    <div>
                        <p>Tidak ada buku.</p>
                    </div>
                @else
                    @foreach ($collections as $books)
                        @foreach ($books as $book)
                            <div
                                class="book bg-slate-50 rounded shadow border border-slate-300 cursor-pointer hover:scale-105 transition">
                                <div class="h-50 bg-slate-400">
                                    <img src="/storage/covers/{{ $book->cover }}" alt="" class="">
                                </div>

                                <div class="p-2">
                                    <h2 class="font-bold text-sm">{{ $book->title }} ({{ $book->year }})</h2>
                                    <div class="text-xs">
                                        @foreach ($book->categories as $category)
                                            <span class="">{{ $category->name }}, </span>
                                        @endforeach
                                    </div>
                                    <p class="text-xs font-semibold text-slate-500">Penulis: {{ $book->author }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
