@extends('member.layouts.app')

@section('content')
    <div>
        <div>
            <div class="max-w-7xl flex bg-gray-50 gap-4 p-4 mx-auto items-center justify-between">
                <p class="font-bold text-lg text-slate-800">Buku Terbaru</p>
                <!-- Filter Kategori -->
                <div class="items-center">
                    <h3 class="text-sm mb-2 font-semibold">Filter Kategori:</h3>
                    <div class="flex gap-3">
                        <div
                            class="h-fit px-2 py-1 rounded-full text-xs w-16 text-center {{ !$selectedCategory ? 'bg-neutral-500 text-amber-50 hover:bg-neutral-500' : 'bg-amber-500 text-amber-50' }} hover:bg-amber-700 hover:border-neutral-500 hover:text-amber-50">
                            <a href="{{ route('member.collection') }}">
                                Semua
                            </a>
                        </div>
                        @foreach ($categories as $category)
                            <div
                                class="h-fit px-2 py-1 rounded-full text-xs w-16 text-center
                          {{ $selectedCategory == $category->id ? 'bg-neutral-500 text-amber-50 hover:bg-neutral-500' : 'bg-amber-500 text-amber-50' }} hover:bg-amber-700 hover:border-neutral-500 hover:text-amber-50">
                                <a href="{{ route('member.collection', ['category' => $category->id]) }}">
                                    {{ $category->name }}
                                </a>
                            </div>
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
