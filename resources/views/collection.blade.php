@extends('layouts.app')

@section('title', 'Koleksi | Perpustakaan Umum Kota Solok')

@section('content')
    <div>

        {{-- New Collection --}}
        <section class="border-b border-neutral-100">
            <div class="w-[1680px] mx-auto">
                <div class="flex bg-white gap-4 p-4 mx-auto items-center justify-between">
                    <div>
                        <p class="font-bold text-lg text-slate-800">Koleksi Terbaru</p>
                        <p class="text-xs">Temukan koleksi menarik disini!</p>
                    </div>
                    <!-- Filter Kategori -->
                    <div class="grid items-center">
                        <h3 class="text-sm mb-2 font-semibold">Filter Kategori:</h3>
                        <div class="flex gap-3">
                            <div
                            class="h-fit px-2 py-1 rounded-full text-xs text-center
                                 {{ is_null($selectedCategory) ? 'bg-neutral-500 text-yellow-50' : 'bg-yellow-500 text-yellow-50' }}
                                 hover:bg-amber-700 hover:text-amber-50">
                                <a href="{{ route('collection') }}">
                                    Semua
                                </a>
                            </div>
                            @foreach ($categories as $category)
                                <div
                                    class="h-fit px-2 py-1 rounded-full text-xs text-center
                                  {{ $selectedCategory == $category->id ? 'bg-neutral-500 text-yellow-50 hover:bg-neutral-500' : 'bg-yellow-500 text-yellow-50' }} hover:bg-yellow-700 hover:border-neutral-500 hover:text-yellow-50">
                                    <a href="{{ route('collection', ['category' => $category->id]) }}">
                                        {{ $category->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class=" bg-white gap-4 p-4 grid grid-cols-6 mx-auto content-around">
                    @foreach ($books as $book)
                        <a href="{{ route('show.book', $book) }}">
                            <div
                                class="book h-full bg-slate-50 rounded shadow border border-slate-300 cursor-pointer hover:scale-105 transition">
                                <div class="h-fit bg-slate-400">
                                    <img src="{{ asset('storage/' . $book->cover) }}" alt="" class="shadow-sm">
                                </div>

                                <div class="p-3">
                                    <h2 class="font-bold text-sm">{{ $book->title }} ({{ $book->year }})</h2>
                                    <div class="text-xs">
                                        @foreach ($book->categories as $category)
                                            <span class="">{{ $category->name }}, </span>
                                        @endforeach
                                    </div>
                                    <p class="text-xs font-semibold text-slate-500">Penulis: {{ $book->author }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Popular Collection --}}
        <section class="border-b border-neutral-100">
            <div class="w-[1680px] mx-auto">
                <div class="flex bg-white gap-4 p-4 mx-auto items-center justify-between">
                    <div>
                        <p class="font-bold text-lg text-slate-800">Populer</p>
                        <p class="text-xs">Rekomendasi buku yang diminati orang lain</p>
                    </div>
                </div>
                <div class=" bg-white gap-4 p-4 grid grid-cols-6 mx-auto content-around">
                    @foreach ($books as $book)
                        <a href="{{ route('show.book', $book->id) }}">
                            <div
                                class="book h-full bg-slate-50 rounded shadow border border-slate-300 cursor-pointer hover:scale-105 transition">
                                <div class="h-fit bg-slate-400">
                                    <img src="{{ asset('storage/' . $book->cover) }}" alt="" class="shadow-sm">
                                </div>

                                <div class="p-3">
                                    <h2 class="font-bold text-sm">{{ $book->title }} ({{ $book->year }})</h2>
                                    <div class="text-xs">
                                        @foreach ($book->categories as $category)
                                            <span class="">{{ $category->name }}, </span>
                                        @endforeach
                                    </div>
                                    <p class="text-xs font-semibold text-slate-500">Penulis: {{ $book->author }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
