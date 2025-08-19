@extends('layouts.app')

@section('title', __('book.page_title'))

@section('content')
    <div class="flex flex-col gap-4">
        <div class="max-w-6xl mx-auto bg-white rounded shadow-md">
            <div class="py-4 bg-sky-50 flex items-center gap-2 border-b border-neutral-300">
                <div title="{{ __('book.back') }}">
                    <a href="{{ route('home') }}" class="flex items-center hover:text-sky-500 w-fit">
                        <i class="w-10 h-10" data-lucide="chevron-left"></i>
                    </a>
                </div>
                <div>
                    <h1 class="font-bold text-neutral-700 text-2xl">{{ __('book.about') }}</h1>
                    <p class="pt-2 font-semibold text-neutral-500">{{ $book->clean_title }}</p>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-6 bg-neutral-50 pr-6">
                {{-- Cover --}}
                <div class="md:w-1/3">
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->clean_title }}"
                        class="rounded shadow-sm w-full object-cover">
                </div>

                {{-- Detail Buku --}}
                <div class="md:w-2/3 space-y-2 text-sm">
                    <div class="grid grid-cols-4 border-b border-neutral-200 items-center py-2">
                        <div class="col-span-1">
                            {{ __('book.title') }}
                        </div>
                        <div class="col-span-3 px-2">
                            <h1 class="font-bold text-slate-800">{{ $book->clean_title }} ({{ $book->edition }})</h1>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 border-b border-neutral-200 items-center py-2">
                        <div class="col-span-1">
                            {{ __('book.author') }}
                        </div>
                        <div class="col-span-3 px-2">
                            <h1 class="text-slate-800">{{ $book->formatted_author }}</h1>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 border-b border-neutral-200 items-center py-2">
                        <div class="col-span-1">
                            {{ __('book.publisher') }}
                        </div>
                        <div class="col-span-3 px-2">
                            <h1 class="text-slate-800">{{ preg_replace('/[:,]/', '', $book->publisher) }} |
                                {{ preg_replace('/[:,]/', '', $book->publication_place) }}</h1>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 border-b border-neutral-200 items-center py-2">
                        <div class="col-span-1 ">
                            {{ __('book.physical') }}
                        </div>
                        <div class="col-span-3 px-2">
                            <h1 class="text-slate-800"><span
                                    class="font-bold text-neutral-500">({{ $book->physical_shape }})</span>
                                {{ $book->physical_description }}</h1>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 border-b border-neutral-200 items-center py-2">
                        <div class="col-span-1">
                            {{ __('book.isbn') }}
                        </div>
                        <div class="col-span-3 px-2">
                            <h1 class="text-slate-800">{{ preg_replace('/[-]/', '', $book->isbn) }}</h1>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 border-b border-neutral-200 items-center py-2">
                        <div class="col-span-1">
                            {{ __('book.year') }}
                        </div>
                        <div class="col-span-3 px-2">
                            <h1 class="text-slate-800">{{ $book->year }}</h1>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 border-b border-neutral-200 items-center py-2">
                        <div class="col-span-1">
                            {{ __('book.category') }}
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
                            {{ __('book.description') }}
                        </div>
                        <div class="py-4 text-justify">
                            {!! $book->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($relatedBooks->count())
            <div class="w-7xl mx-auto">
                <h2 class="text-xl font-bold mb-4 text-slate-800">{{ __('book.related') }}</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach ($relatedBooks as $related)
                        <a href="{{ route('show.book', $related) }}"
                            class="bg-white rounded shadow border border-neutral-300 hover:scale-105 transition h-40">
                            <img src="{{ asset('storage/' . $related->cover) }}" class="w-full object-cover rounded-t"
                                alt="{{ $related->title }}">
                            <div class="p-2">
                                <h3 class="font-semibold text-sm truncate">{{ $related->title }}</h3>
                                <p class="text-xs text-gray-500">{{ __('book.writer') }}: {{ $related->author }}</p>
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
