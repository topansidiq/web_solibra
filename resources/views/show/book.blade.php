@extends('welcome')

@section('content')
    <div class="flex flex-col gap-4">
        <div class="max-w-6xl mx-auto bg-white rounded shadow-md">
            <div class="py-4 bg-sky-50 flex items-center gap-2 border-b border-neutral-300">
                <div title="Kembali">
                    <a href="{{ route('home') }}" class="flex items-center hover:text-sky-500 w-fit">
                        <i class="w-10 h-10" data-lucide="chevron-left"></i>
                    </a>
                </div>
                <div>
                    <h1 class="font-bold text-neutral-700 text-2xl">Tentang Buku Ini</h1>
                    <p class="pt-2 font-semibold text-neutral-500">{{ $book->title }}</p>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-6 bg-neutral-50 pr-6">
                {{-- Cover --}}
                <div class="md:w-1/3">
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}"
                        class="rounded shadow-sm w-full object-cover">
                </div>

                {{-- Detail Buku --}}
                <div class="md:w-2/3 space-y-2 text-sm">

                    <div class="grid grid-cols-4 border-b border-neutral-200 items-center py-2">
                        <div class="col-span-1">
                            Judul
                        </div>
                        <div class="col-span-3 px-2">
                            <h1 class="font-bold text-slate-800">{{ $book->title }}</h1>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 border-b border-neutral-200 items-center py-2">
                        <div class="col-span-1">
                            Penulis
                        </div>
                        <div class="col-span-3 px-2">
                            <h1 class="text-slate-800">{{ $book->author }}</h1>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 border-b border-neutral-200 items-center py-2">
                        <div class="col-span-1 ">
                            Penerbit
                        </div>
                        <div class="col-span-3 px-2">
                            <h1 class="text-slate-800">{{ $book->publisher }}</h1>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 border-b border-neutral-200 items-center py-2">
                        <div class="col-span-1">
                            ISBN
                        </div>
                        <div class="col-span-3 px-2">
                            <h1 class="text-slate-800">{{ $book->isbn }}</h1>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 border-b border-neutral-200 items-center py-2">
                        <div class="col-span-1">
                            Tahun Terbit
                        </div>
                        <div class="col-span-3 px-2">
                            <h1 class="text-slate-800">{{ $book->year }}</h1>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 border-b border-neutral-200 items-center py-2">
                        <div class="col-span-1">
                            Kategori
                        </div>
                        <div class="col-span-3 px-2">
                            @foreach ($book->categories as $category)
                                <span class="inline-block bg-sky-200 text-neutral-800 px-2 py-0.5 rounded text-xs mr-1">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="items-center py-2">
                        <div class="col-span-4 font-semibold">
                            Deskripsi
                        </div>
                        <div class="py-4 text-justify">
                            {{ $book->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($relatedBooks->count())
            <div class="w-7xl mx-auto">
                <h2 class="text-xl font-bold mb-4 text-slate-800">Buku Serupa</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach ($relatedBooks as $related)
                        <a href="{{ route('show.book', $related) }}"
                            class="bg-white rounded shadow border border-neutral-300 hover:scale-105 transition h-40">
                            <img src="{{ asset('storage/' . $related->cover) }}" class="w-full object-cover rounded-t"
                                alt="{{ $related->title }}">
                            <div class="p-2">
                                <h3 class="font-semibold text-sm truncate">{{ $related->title }}</h3>
                                <p class="text-xs text-gray-500">Penulis: {{ $related->author }}</p>
                                <span class="text-xs text-gray-400">
                                    {{ $related->categories->pluck('name')->join(', ') }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
