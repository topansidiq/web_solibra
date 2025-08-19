@extends('layouts.app')

@section('title', __('main.navigation.home') . ' | Perpustakaan Umum Kota Solok')

@section('content')
    <main>
        <script src="{{ asset('js/guest/home.js') }}"></script>
        <div class="grid">
            <section
                class="xl:flex grid w-full overflow-hidden shadow-lg bg-cover bg-no-repeat bg-center items-center justify-between 2xl:px-30 2xl:py-24 text-slate-50 text-shadow-md"
                style="background-image: url({{ asset('img/Perpustakaan_Umum_Kota_Solok.jpg') }})">
                <div class="md:p-10 lg:p-16 p-5">
                    <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4">
                        <span class="block text-xl">{{ __('message.welcome', ['puks' => '']) }}</span>
                        <span>
                            {{ __('main.puks') }}
                        </span>
                    </h1>
                    <div class="hidden lg:flex gap-4">
                        <a href="#"
                            class=" bg-yellow-500 hover:bg-yellow-700 text-white px-5 py-2 rounded-full shadow-md transition duration-300">
                            {{ __('message.contact_us') }}
                        </a>
                    </div>
                </div>
            </section>

            {{-- Beranda --}}
            <section class="py-5 px-6 w-full bg-white">

                <div class="hidden md:grid grid-rows-2 grid-cols-3 md:max-w-7xl max-h-80 mx-auto justify-center gap-4">

                    <div class="col-span-2 row-span-2 rounded-2xl md:relative overflow-hidden shadow-md border border-neutral-200"
                        x-data="{
                            currentIndex: 0,
                            total: {{ count($latestMedia) }},
                            interval: null,
                            startAutoplay() {
                                this.interval = setInterval(() => {
                                    this.currentIndex = (this.currentIndex + 1) % this.total;
                                }, 7000);
                            },
                            stopAutoplay() {
                                clearInterval(this.interval);
                            }
                        }" x-init="startAutoplay()" @mouseenter="stopAutoplay"
                        @mouseleave="startAutoplay">
                        <!-- Slides -->
                        <template x-for="(media, index) in {{ json_encode($latestMedia) }}" :key="index">
                            <div x-show="currentIndex === index" x-transition.opacity.duration.500ms
                                class="md:absolute inset-0">

                                <!-- Image -->
                                <template x-if="media.type === 'image'">
                                    <img :src="'/storage/' + media.file" class="w-full h-full object-cover rounded-2xl">
                                </template>

                                <!-- Video -->
                                <template x-if="media.type === 'video'">
                                    <video controls class="w-full h-full object-cover rounded-2xl">
                                        <source :src="'/storage/' + media.file" type="video/mp4">
                                        {{ __('home.video_failed') }}
                                    </video>
                                </template>

                                <!-- Judul overlay -->
                                <div class="w-full text-sm text-center py-2 rounded-b-2xl z-30">
                                    <span>{{ __('home.new') }}</span>
                                </div>
                            </div>
                        </template>

                        <!-- Tombol navigasi -->
                        <button @click="currentIndex = (currentIndex - 1 + total) % total"
                            class="md:absolute left-3 top-1/2 -translate-y-1/2 bg-black bg-opacity-40 text-white rounded-full w-8 h-8 flex items-center justify-center">
                            ‹
                        </button>
                        <button @click="currentIndex = (currentIndex + 1) % total"
                            class="md:absolute right-3 top-1/2 -translate-y-1/2 bg-black bg-opacity-40 text-white rounded-full w-8 h-8 flex items-center justify-center">
                            ›
                        </button>

                        <!-- Indicator -->
                        <div class="md:absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2">
                            <template x-for="(media, index) in {{ json_encode($latestMedia) }}" :key="'dot-' + index">
                                <div @click="currentIndex = index"
                                    :class="currentIndex === index ? 'bg-white' : 'bg-gray-400'"
                                    class="w-3 h-3 rounded-full cursor-pointer ring-1 ring-gray-300 transition"></div>
                            </template>
                        </div>
                    </div>

                    <!-- Banner kanan atas -->
                    <div class="col-auto row-auto md:relative shadow-md border border-neutral-200 rounded-2xl">
                        @if ($newItem['book'])
                            <img src="{{ asset('storage/' . $newItem['book']->cover) }}" alt=""
                                class="w-full h-full object-cover rounded-2xl">
                            <div
                                class="md:absolute bottom-0 w-full bg-gradient-to-t from-black/80 via-black/50 to-transparent text-white text-sm text-center py-1 rounded-b-2xl">
                                <div class="flex items-center justify-between px-5 py-3">
                                    <a href="{{ route('show.book', $newItem['book']) }}"
                                        class="block px-2 py-1 rounded-md text-sm bg-sky-500 text-neutral-50">{{ __('home.show_detail') }}</a>
                                    <span class="block">{{ __('home.new_book') }}</span>
                                </div>
                            </div>
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-t from-black/80 via-black/50 to-transparent rounded-2xl flex items-center justify-center">
                                <span class="text-gray-900 z-50">{{ __('home.no_book') }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Banner kanan bawah -->
                    <div class="col-auto row-auto md:relative shadow-md border border-neutral-200 rounded-2xl">
                        @if ($newItem['event'])
                            <img src="{{ asset('storage/' . $newItem['event']->poster) }}" alt=""
                                class="w-full h-full object-cover rounded-2xl">
                            <div
                                class="absolute bottom-0 w-full  bg-gradient-to-t from-black/80 via-black/50 to-transparent text-white text-sm text-center py-1 rounded-b-2xl">
                                <div class="flex items-center justify-between px-5 py-3">
                                    <a href="{{ route('event', $newItem['event']) }}"
                                        class="block px-2 py-1 rounded-md text-sm bg-sky-500 text-neutral-50">{{ __('home.show_detail') }}</a>
                                    <span class="block">{{ __('home.new_event') }}</span>
                                </div>
                            </div>
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-t from-black/80 via-black/50 to-transparent rounded-2xl flex items-center justify-center">
                                <span class="text-gray-500 z-50">{{ __('home.no_event') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- Latest Collection --}}
            <section class="md:py-1 px-2 w-full mx-auto bg-white border-t border-neutral-100">
                <div class="max-w-7xl mx-auto p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="font-bold text-neutral-700 text-xl">{{ __('home.recommendation') }}</h1>
                            <p class="text-xs ">{{ __('home.recommendation_message') }}</p>
                        </div>
                        <div class="flex gap-3">
                            <div class="rounded-md px-1 py-0.5 text-xs bg-sky-200">
                                <a href="#">{{ __('home.recommendation_button') }}</a>
                            </div>
                            <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200 text-center">
                                <a href="#">Teknologi</a>
                            </div>
                            <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200 text-center">
                                <a href="#">Sejarah</a>
                            </div>
                            <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200 text-center">
                                <a href="#">Religi</a>
                            </div>
                            <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200 text-center">
                                <a href="#">Novel</a>
                            </div>
                        </div>
                    </div>
                    <div
                        class="gap-4 xl:p-4 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6 mx-auto content-around">
                        @foreach ($latestBook as $book)
                            <a href="{{ route('show.book', $book) }}">
                                <div
                                    class="book h-full bg-slate-50 rounded-md shadow border border-slate-300 cursor-pointer hover:scale-105 transition">

                                    @if ($book->cover && Storage::disk('public')->exists($book->cover))
                                        <div class="h-72">
                                            <img src="{{ asset('storage/' . $book->cover) }}" alt="">
                                        </div>
                                    @else
                                        <div class="h-72 bg-cover bg-no-repeat py-10 flex items-center justify-center text-white text-2xl font-semibold"
                                            style="background-image: url({{ asset('img/default_cover.jpg') }})">
                                            <h1 class="p-3">{{ $book->clean_title }}</h1>
                                        </div>
                                    @endif

                                    <div class="p-3">
                                        <h2 class="font-bold text-sm">{{ $book->clean_title }} ({{ $book->year }})
                                        </h2>
                                        <div class="text-xs">
                                            @foreach ($book->categories as $category)
                                                <span>{{ $category->name }}@if (!$loop->last)
                                                        ,
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                        <p class="text-xs font-semibold text-slate-500">{{ __('home.author') }}:
                                            {{ $book->formatted_author }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Popular Collection --}}
            <section class="md:py-1 px-2 w-full mx-auto bg-white border-t border-neutral-100">
                <div class="max-w-7xl mx-auto p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="font-bold text-neutral-700 text-xl">{{ __('home.popular') }}</h1>
                            <p class="text-xs ">{{ __('home.popular_message') }}</p>
                        </div>
                        <div class="flex gap-3">
                            <div class="rounded-md px-1 py-0.5 text-xs bg-sky-200">
                                <a href="#">{{ __('home.popular_button') }}</a>
                            </div>
                            <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200 text-center">
                                <a href="#">2024</a>
                            </div>
                            <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200 text-center">
                                <a href="#">2023</a>
                            </div>
                        </div>
                    </div>
                    <div
                        class=" gap-4 xl:p-4 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6 mx-auto content-around">
                        @foreach ($latestBook as $book)
                            <a href="{{ route('show.book', $book) }}">
                                <div
                                    class="book h-full bg-slate-50 rounded-md shadow border border-slate-300 cursor-pointer hover:scale-105 transition">

                                    @if ($book->cover && Storage::disk('public')->exists($book->cover))
                                        <div class="h-72">
                                            <img src="{{ asset('storage/' . $book->cover) }}" alt="">
                                        </div>
                                    @else
                                        <div class="h-72 bg-cover bg-no-repeat py-10 flex items-center justify-center text-white text-2xl font-semibold"
                                            style="background-image: url({{ asset('img/default_cover.jpg') }})">
                                            <h1 class="p-3">{{ $book->clean_title }}</h1>
                                        </div>
                                    @endif

                                    <div class="p-3">
                                        <h2 class="font-bold text-sm">{{ $book->clean_title }} ({{ $book->year }})
                                        </h2>
                                        <div class="text-xs">
                                            @foreach ($book->categories as $category)
                                                <span>{{ $category->name }}@if (!$loop->last)
                                                        ,
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                        <p class="text-xs font-semibold text-slate-500">{{ __('home.author') }}:
                                            {{ $book->formatted_author }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Latest Event --}}
            <section class="md:py-1 px-2 w-full mx-auto bg-white border-t border-neutral-100">
                <div class="max-w-7xl mx-auto p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="font-bold text-neutral-700 text-xl">{{ __('home.event') }}</h1>
                            <p class="text-xs ">{{ __('home.event_message') }}</p>
                        </div>
                        <div class="flex gap-3">
                            <div class="rounded-md px-1 py-0.5 text-xs bg-sky-200">
                                <a href="#">{{ __('home.event_buttons.ongoing') }}</a>
                            </div>
                            <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200">
                                <a href="#">{{ __('home.event_buttons.upcoming') }}</a>
                            </div>
                            <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200">
                                <a href="#">{{ __('home.event_buttons.completed') }}</a>
                            </div>
                            <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200">
                                <a href="#">{{ __('home.event_buttons.cancelled') }}</a>
                            </div>
                        </div>
                    </div>
                    <div
                        class="gap-4 xl:p-4 grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-3 mx-auto content-around">
                        @if ($latestEvent->isEmpty())
                            <p class="text-black">{{ __('home.no_event') }}</p>
                        @else
                            @foreach ($latestEvent as $event)
                                <a href="{{ route('show.event', $event) }}">
                                    <div
                                        class="book h-full bg-slate-50 rounded-md shadow border border-slate-300 cursor-pointer hover:scale-105 transition">

                                        @if ($book->cover && Storage::disk('public')->exists($book->cover))
                                            <div class="h-72">
                                                <img src="{{ asset('storage/' . $event->poster) }}" alt=""
                                                    class="w-full h-full object-cover rounded">
                                            </div>
                                        @else
                                            <div class="h-72 bg-cover bg-no-repeat py-10 flex items-center justify-center text-white text-2xl font-semibold"
                                                style="background-image: url({{ asset('img/default_cover.jpg') }})">
                                                <h1 class="p-3">{{ $book->clean_title }}</h1>
                                            </div>
                                        @endif

                                        <div class="p-3">
                                            <h2 class="font-bold text-sm">{{ $event->title }} ({{ $event->start_at }})
                                            </h2>
                                            <p class="text-xs font-semibold text-slate-500">
                                                @if ($event->status === 'ongoing')
                                                    {{ __('home.event_buttons.ongoing') }}
                                                @elseif ($event->status === 'upcoming')
                                                    {{ __('home.event_buttons.upcoming') }}
                                                @elseif ($event->status === 'completed')
                                                    {{ __('home.event_buttons.completed') }}
                                                @elseif ($event->status === 'cancelled')
                                                    {{ __('home.event_buttons.cancelled') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
