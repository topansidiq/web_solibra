@extends('member.layouts.app')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8">

        {{-- KOLEKSI TERBARU --}}
        <div class="xl:mx-10 p-4 bg-white rounded-2xl border-slate-200">
            {{-- Header & Filter --}}
            <div class="flex flex-col xl:flex-row gap-4 items-start xl:items-center justify-between mb-6">
                <h2 class="font-bold text-xl text-sky-800">{{ __('collection.new_collection') }}</h2>

                {{-- Filter Kategori --}}
                <div>
                    <h3 class="text-sm mb-2 font-semibold text-slate-700">{{ __('collection.category_filter') }}</h3>
                    <div class="flex flex-wrap gap-2">
                        {{-- Semua --}}
                        <a href="{{ route('member.collection') }}" class="px-4 py-1.5 rounded-full text-xs font-medium transition-all
                                {{ is_null($selectedCategory)
                                    ? 'bg-sky-800 text-white shadow-sm'
                                    : 'bg-sky-500 text-white hover:bg-sky-600 shadow-sm' }}">
                            {{ __('collection.all') }}
                        </a>
                        {{-- Per kategori --}}
                        @foreach ($categories as $category)
                                        <a href="{{ route('member.collection', ['category' => $category->id]) }}" class="px-4 py-1.5 rounded-full text-xs font-medium transition-all
                                                    {{ $selectedCategory == $category->id
                            ? 'bg-sky-800 text-white shadow-sm'
                            : 'bg-sky-500 text-white hover:bg-sky-600 shadow-sm' }}">
                                            {{ $category->name }}
                                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Grid Koleksi --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-5">
                @foreach ($books as $book)
                    <a href="{{ route('member.collection.show', $book->id) }}" class="block bg-white rounded-xl shadow hover:shadow-lg border border-slate-200
                                   hover:scale-105 transition transform overflow-hidden">

                        {{-- Cover Buku --}}
                        @if (!empty($book->cover) && Storage::disk('public')->exists($book->cover))
                            <div class="h-72 bg-cover bg-center"
                                style="background-image: url('{{ asset('storage/' . $book->cover) }}')"></div>
                        @else
                            <div class="h-72 bg-sky-800 flex items-center justify-center text-white text-center p-4">
                                <h1 class="text-lg font-semibold drop-shadow-lg">{{ $book->clean_title }}</h1>
                            </div>
                        @endif

                        {{-- Info Buku --}}
                        <div class="p-3">
                            <h2 class="font-bold text-sm line-clamp-2 text-slate-800">
                                {{ $book->title }} ({{ $book->year }})
                            </h2>
                            <div class="text-xs text-gray-500 mb-1">
                                @foreach ($book->categories as $category)
                                    <span>{{ $category->name }}</span>@if(!$loop->last), @endif
                                @endforeach
                            </div>
                            <p class="text-xs font-medium text-sky-700">{{ __('collection.author') }} {{ $book->author }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- DAFTAR PINJAMAN --}}

        <div class="xl:mx-10 p-4 bg-white rounded-2xl border-slate-200">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-bold text-xl text-sky-800">{{ __('collection.your_borrowed') }}</h2>
            </div>

            @if ($collections->isEmpty())
                <div class="px-4 py-8 bg-slate-50 rounded-lg text-center text-gray-500 text-sm">
                    {{ __('home.no_book') }}
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-5">
                    @foreach ($collections as $book)
                        <a href="{{ route('show.book', $book) }}" class="block bg-white rounded-xl shadow hover:shadow-lg border border-slate-200
                                           hover:scale-105 transition transform overflow-hidden">

                            {{-- Cover Buku --}}
                            @if (!empty($book->cover) && Storage::disk('public')->exists($book->cover))
                                <div class="h-72 bg-cover bg-center"
                                    style="background-image: url('{{ asset('storage/' . $book->cover) }}')"></div>
                            @else
                                <div class="h-72 bg-sky-800 flex items-center justify-center text-white text-center p-4">
                                    <h1 class="text-lg font-semibold drop-shadow-lg">{{ $book->clean_title }}</h1>
                                </div>
                            @endif

                            {{-- Info Buku --}}
                            <div class="p-3">
                                <h2 class="font-bold text-sm line-clamp-2 text-slate-800">
                                    {{ $book->title }} ({{ $book->year }})
                                </h2>
                                <div class="text-xs text-gray-500 mb-1">
                                    @foreach ($book->categories as $category)
                                        <span>{{ $category->name }}</span>@if(!$loop->last), @endif
                                    @endforeach
                                </div>
                                <p class="text-xs font-medium text-sky-700">Penulis: {{ $book->author }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
