@extends('member.layouts.app')

@section('content')
    <div>
        <div class="border-x border-neutral-200 xl:mx-52 p-4 px-5">
            <div class="xl:flex gap-4 p-4 mx-auto items-center justify-between">
                <p class="font-bold text-lg text-slate-800">Koleksi Terbaru</p>
                <!-- Filter Kategori -->
                <div class="items-center">
                    <h3 class="text-sm mb-2 font-semibold">Filter Kategori:</h3>
                    <div class="flex gap-3">
                        <div
                            class="h-fit px-2 py-1 rounded-full text-xs w-16 text-center
        {{ is_null($selectedCategory) ? 'bg-neutral-500 text-amber-50' : 'bg-yellow-500 text-amber-50' }}
        hover:bg-yellow-700 hover:text-amber-50">
                            <a href="{{ route('collection') }}">
                                Semua
                            </a>
                        </div>
                        @foreach ($categories as $category)
                            <div
                                class="h-fit px-2 py-1 rounded-full text-xs w-16 text-center
                          {{ $selectedCategory == $category->id ? 'bg-neutral-500 text-amber-50 hover:bg-neutral-500' : 'bg-yellow-500 text-neutral-50' }} hover:bg-yellow-700 hover:border-neutral-500 hover:text-amber-50 w-fit">
                                <a href="{{ route('collection', ['category' => $category->id]) }}">
                                    {{ $category->name }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-3">
                @foreach ($books as $book)
                    <a href="{{ route('show.book', $book) }}"
                        class="block book bg-slate-50 rounded shadow-md border border-slate-300 cursor-pointer hover:scale-105 transition">
                        <div class="h-36 md:h-44 lg:h-60 xl:h-72 bg-sky-500"
                            style="background-image: url('{{ asset('storage/' . $book->cover) }}'); background-repeat: no-repeat; background-size: cover;">
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
                    </a>
                @endforeach
            </div>
        </div>
        <div class="w-[1680px] mx-auto">
            <div class="flex bg-gray-50 gap-4 p-4 mx-auto items-center justify-between">
                <p class="font-bold text-lg text-slate-800">Daftar Pinjaman Kamu</p>
            </div>
            <div class="bg-gray-50 gap-4 p-4 grid grid-cols-6 mx-auto content-around">
                @if ($collections->isEmpty())
                    <div class="px-5">
                        <p>Tidak ada buku.</p>
                    </div>
                @else
                    @foreach ($collections as $books)
                        @foreach ($books as $book)
                            <a href="block" href="{{ route('books.show', $book->title) }}">
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
                            </a>
                        @endforeach
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
