@extends('layouts.app')

@section('title', 'Beranda | Perpustakaan Umum Kota Solok')

@section('content')
    {{-- @if (request()->is('/') || request()->is('home')) --}}
    <main>
        <script src="{{ asset('js/guest/home.js') }}"></script>
        <div class="grid gap-3">
            <section
                class="xl:flex grid w-full overflow-hidden shadow-lg bg-cover bg-no-repeat bg-center items-center justify-between 2xl:px-30 2xl:py-24 text-slate-50 text-shadow-md"
                style="background-image: url({{ asset('img/Perpustakaan_Umum_Kota_Solok.jpg') }})">
                <div class="md:p-10 lg:p-16 p-5">
                    <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4">
                        <span class="block text-xl">{{ __('message.welcome', ['puks' => '']) }}</span>
                        <span>
                            Perpustakaan Umum Kota Solok
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
            <section class="py-10 px-6 w-full bg-white">

                <div class="grid grid-rows-2 grid-cols-3 max-w-7xl w-5xl max-h-80 mx-auto justify-center gap-4">

                    <div class="col-span-2 row-span-2 rounded-2xl relative overflow-hidden shadow-md border border-neutral-200"
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
                                class="absolute inset-0">

                                <!-- Image -->
                                <template x-if="media.type === 'image'">
                                    <img :src="'/storage/' + media.file" class="w-full h-full object-cover rounded-2xl">
                                </template>

                                <!-- Video -->
                                <template x-if="media.type === 'video'">
                                    <video controls class="w-full h-full object-cover rounded-2xl">
                                        <source :src="'/storage/' + media.file" type="video/mp4">
                                        Browser tidak mendukung video.
                                    </video>
                                </template>

                                <!-- Judul overlay -->
                                <div
                                    class="absolute bottom-0 w-full bg-gradient-to-t from-black/80 via-black/50 to-transparent text-white text-sm text-center py-2 rounded-b-2xl z-30">
                                    <span>Terbaru</span>
                                </div>
                            </div>
                        </template>

                        <!-- Tombol navigasi -->
                        <button @click="currentIndex = (currentIndex - 1 + total) % total"
                            class="absolute left-3 top-1/2 -translate-y-1/2 bg-black bg-opacity-40 text-white rounded-full w-8 h-8 flex items-center justify-center">
                            ‹
                        </button>
                        <button @click="currentIndex = (currentIndex + 1) % total"
                            class="absolute right-3 top-1/2 -translate-y-1/2 bg-black bg-opacity-40 text-white rounded-full w-8 h-8 flex items-center justify-center">
                            ›
                        </button>

                        <!-- Indicator -->
                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2">
                            <template x-for="(media, index) in {{ json_encode($latestMedia) }}" :key="'dot-' + index">
                                <div @click="currentIndex = index"
                                    :class="currentIndex === index ? 'bg-white' : 'bg-gray-400'"
                                    class="w-3 h-3 rounded-full cursor-pointer ring-1 ring-gray-300 transition"></div>
                            </template>
                        </div>
                    </div>

                    <!-- Banner kanan atas -->
                    <div class="col-auto row-auto relative shadow-md border border-neutral-200 rounded-2xl">
                        @if ($newItem['book'])
                            <img src="{{ asset('storage/' . $newItem['book']->cover) }}" alt=""
                                class="w-full h-full object-cover rounded-2xl">
                            <div
                                class="absolute bottom-0 w-full  bg-gradient-to-t from-black/80 via-black/50 to-transparent text-white text-sm text-center py-1 rounded-b-2xl">
                                Buku Terbaru
                            </div>
                        @else
                            <div
                                class="w-full h-full  bg-gradient-to-t from-black/80 via-black/50 to-transparent rounded-2xl flex items-center justify-center">
                                <span class="text-gray-900 z-50">No Book</span>
                            </div>
                        @endif
                    </div>

                    <!-- Banner kanan bawah -->
                    <div class="col-auto row-auto relative shadow-md border border-neutral-200 rounded-2xl">
                        @if ($newItem['event'])
                            <img src="{{ asset('storage/' . $newItem['event']->poster) }}" alt=""
                                class="w-full h-full object-cover rounded-2xl">
                            <div
                                class="absolute bottom-0 w-full  bg-gradient-to-t from-black/80 via-black/50 to-transparent text-white text-sm text-center py-1 rounded-b-2xl">
                                Kegiatan Terbaru
                            </div>
                        @else
                            <div
                                class="w-full h-full  bg-gradient-to-t from-black/80 via-black/50 to-transparent rounded-2xl flex items-center justify-center">
                                <span class="text-gray-500 z-50">No Event</span>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- Latest Collection --}}
            <section class="md:py-1 px-2 w-full mx-auto bg-sky-50">
                <div class="max-w-7xl mx-auto p-2">
                    <div>
                        <h1 class="font-bold text-neutral-700 text-xl p-2">Terbaru</h1>
                    </div>
                    <div
                        class="gap-4 xl:p-4 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6 mx-auto content-around">
                        @foreach ($latestBook as $book)
                            <a href="{{ route('show.book', $book) }}">
                                <div
                                    class="book h-full bg-slate-50 rounded-md shadow border border-slate-300 cursor-pointer hover:scale-105 transition">

                                    @if ($book->cover && Storage::disk('public')->exists($book->cover))
                                        <div class="h-72"
                                            style="background-image: url({{ asset('storage/' . $book->cover) }})">
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
                                        <p class="text-xs font-semibold text-slate-500">Penulis:
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
            <section class="md:py-1 px-2 w-full mx-auto bg-white">
                <div class="max-w-7xl mx-auto p-2">
                    <div>
                        <h1 class="font-bold text-neutral-700 text-xl p-2">Koleksi Populer</h1>
                    </div>
                    <div
                        class=" gap-4 xl:p-4 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6 mx-auto content-around">
                        @foreach ($latestBook as $book)
                            <a href="{{ route('show.book', $book) }}">
                                <div
                                    class="book h-full bg-slate-50 rounded-md shadow border border-slate-300 cursor-pointer hover:scale-105 transition">

                                    @if ($book->cover && Storage::disk('public')->exists($book->cover))
                                        <div class="h-72"
                                            style="background-image: url({{ asset('storage/' . $book->cover) }})">
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
                                        <p class="text-xs font-semibold text-slate-500">Penulis:
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
            <section class="md:py-1 px-2 w-full mx-auto bg-sky-50">
                <div class="max-w-7xl mx-auto p-2">
                    <div>
                        <h1 class="font-bold text-neutral-700 text-xl p-2">Kegiatan Terbaru</h1>
                    </div>
                    <div
                        class="gap-4 xl:p-4 grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-3 mx-auto content-around">
                        @if ($latestEvent->isEmpty())
                            <p class="text-black">Tidak ada kegiatan</p>
                        @else
                            @foreach ($latestEvent as $event)
                                <a href="{{ route('show.event', $event) }}">
                                    <div
                                        class="book h-full bg-slate-50 rounded-md shadow border border-slate-300 cursor-pointer hover:scale-105 transition">

                                        @if ($event->poster && Storage::disk('public')->exists($event->poster))
                                            <div class="h-96 bg-no-repeat bg-cover"
                                                style="background-image: url({{ asset('storage/' . $event->poster) }})">
                                            </div>
                                        @else
                                            <div class="h-72 bg-cover bg-no-repeat py-10 flex items-center justify-center text-white text-2xl font-semibold"
                                                style="background-image: url({{ asset('img/default_cover.jpg') }})">
                                                <h1 class="p-3">{{ $event->title }}</h1>
                                            </div>
                                        @endif

                                        <div class="p-3">
                                            <h2 class="font-bold text-sm">{{ $event->title }} ({{ $event->start_at }})
                                            </h2>
                                            <p class="text-xs font-semibold text-slate-500">
                                                {{ $event->status }}
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
