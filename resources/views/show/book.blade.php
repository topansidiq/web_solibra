@extends('layouts.app')

@section('title', __('book.page_title'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6 space-y-10">

        {{-- Detail Buku --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="py-4 bg-sky-50 flex items-center justify-between gap-2 border-b border-neutral-300 px-4">
                <div class="flex items-center">
                    <a href="{{ route('collection') }}" class="flex items-center hover:text-sky-500">
                        <i class="w-10 h-10" data-lucide="chevron-left"></i>
                    </a>
                    <div>
                        <h1 class="font-bold text-neutral-700 text-2xl">{{ __('book.about')}}</h1>
                        <p class="pt-1 font-semibold text-neutral-500">{{ $book->title }}</p>
                    </div>
                </div>
            </div>
            <div>
                <div x-data="{ show: {{ session('error') ? 'true' : 'false' }} }" x-show="show" x-init="setTimeout(() => show = false, {{ session('duration') ? session('duration') : 6000 }})" class="transition-all ease-in-out"
                    x-transition x-cloak>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold bg-red-300 px-2 py-1 rounded-sm">{{ __('main.failed') }}</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
                <div x-data="{ show: {{ session('success') ? 'true' : 'false' }} }" x-show="show" x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out"
                    x-transition x-cloak>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold bg-green-300 px-2 py-1 rounded-sm">{{ __('main.success') }}</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-6 bg-neutral-50 p-6">
                {{-- Cover --}}
                @if (!empty($book->cover) && Storage::disk('public')->exists($book->cover))
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}"
                        class="w-full md:w-64 lg:w-72 object-cover rounded-lg shadow-sm">
                @else
                    <div
                        class="h-auto max-h-[500px] w-full md:w-64 lg:w-72 bg-sky-800 flex items-center justify-center text-white text-center p-4 rounded-lg shadow-sm">
                        <h1 class="text-lg font-semibold">{{ $book->clean_title }}</h1>
                    </div>
                @endif

                {{-- Detail --}}
                <div class="flex-1 space-y-2 text-sm">
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
                    <div class="grid grid-cols-4 border-b border-neutral-200 py-2">
                        <div class="col-span-1">{{ __('book.stock') }}</div>
                        <div class="col-span-3 px-2 space-x-1">
                            {{ $book->stock }}
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

        {{-- Buku Serupa --}}
        <div>
            <h2 class="text-xl font-bold mb-4 text-slate-800">{{ __('book.related') }}</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
                @foreach ($relatedBooks as $related)
                    <a href="{{ route('show.book', $related) }}"
                        class="block bg-white rounded-xl shadow hover:shadow-lg border border-slate-200
                          hover:scale-105 transition-transform overflow-hidden">

                        {{-- Cover --}}
                        @if (!empty($related->cover) && Storage::disk('public')->exists($related->cover))
                            <div class="h-64 bg-cover bg-center"
                                style="background-image: url('{{ asset('storage/' . $related->cover) }}')"></div>
                        @else
                            <div class="h-64 bg-sky-800 flex items-center justify-center text-white text-center p-4">
                                <h1 class="text-sm font-semibold">{{ $related->clean_title }}</h1>
                            </div>
                        @endif

                        {{-- Info --}}
                        <div class="p-3 space-y-1">
                            <h2 class="font-bold text-sm line-clamp-2 text-slate-800">
                                {{ $related->clean_title }} ({{ $related->year }})
                            </h2>
                            <div class="text-xs text-gray-500 truncate">
                                {{ $related->categories->pluck('name')->join(', ') }}
                            </div>
                            <p class="text-xs font-medium text-sky-700 line-clamp-2">
                                {{ __('book.author') }}: {{ $related->formatted_author }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
