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
                        <span class="block text-xl">Selamat Datang di</span>
                        <span>
                            Perpustakaan<br>Umum Kota Solok
                        </span>
                    </h1>
                    <div class="hidden lg:flex gap-4">
                        <a href="#"
                            class=" bg-yellow-500 hover:bg-yellow-700 text-white px-5 py-2 rounded-full shadow-md transition duration-300">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </section>

            {{-- Beranda --}}
            <section class="py-10 px-6 mx-auto w-full bg-white">
                <div
                    class="flex flex-col xl:flex-row w-full h-auto xl:h-96 max-w-7xl items-center justify-center gap-6 m-auto">
                    <!-- Kolom kiri -->
                    <div class="w-full xl:w-3/5 h-64 xl:h-full rounded-3xl p-6 overflow-hidden">
                        <div class="relative w-full h-full mx-auto overflow-hidden rounded-2xl">

                            {{-- Radio dan Media --}}
                            @foreach ($latestMedia as $index => $media)
                                <input type="radio" name="carousel" id="carousel-{{ $index }}" class="hidden peer"
                                    @checked($loop->first)>

                                <div
                                    class="absolute inset-0 transition-opacity duration-700 ease-in-out opacity-0 peer-checked:opacity-100">
                                    @if ($media->type === 'image')
                                        <img src="{{ asset('storage/' . $media->file) }}"
                                            alt="Gallery Image {{ $index }}"
                                            class="w-full h-full object-cover rounded-2xl">
                                    @elseif ($media->type === 'video')
                                        <video controls class="w-full h-full object-cover rounded-2xl">
                                            <source src="{{ asset('storage/' . $media->file) }}" type="video/mp4">
                                            Browser tidak mendukung pemutaran video.
                                        </video>
                                    @endif
                                </div>
                            @endforeach

                            {{-- Navigasi --}}
                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                                @foreach ($latestMedia as $index => $media)
                                    <label for="carousel-{{ $index }}"
                                        class="w-3 h-3 rounded-full bg-white opacity-70 cursor-pointer ring-1 ring-gray-300 hover:bg-gray-400 transition">
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <!-- Kolom kanan -->
                    <div class="grid w-full xl:w-2/5 h-64 xl:h-full gap-6">
                        <div class="bg-amber-100 rounded-2xl h-full overflow-hidden">
                            <img src="{{ asset('img/weekend-sale-banner-template-promotion-vector.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-2xl">
                        </div>
                        <div class="bg-amber-400 rounded-2xl h-full overflow-hidden">
                            <img src="{{ asset('img/discount-promo-landscape-banner-template-design-b2d961494cf7721d73884d8a307ac771_screen.jpg') }}"
                                alt="" class="w-full h-full object-cover rounded-2xl">
                        </div>
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
