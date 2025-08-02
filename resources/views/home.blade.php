@extends('layouts.app')

@section('title', 'Beranda | Perpustakaan Umum Kota Solok')

@section('content')
    @if (request()->is('/') || request()->is('home'))
        <main>
            <script src="{{ asset('js/guest/home.js') }}"></script>
            <div>
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
                                    <input type="radio" name="carousel" id="carousel-{{ $index }}"
                                        class="hidden peer" @checked($loop->first)>

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
                                <img src="{{ asset('img/weekend-sale-banner-template-promotion-vector.jpg') }}"
                                    alt="" class="w-full h-full object-cover rounded-2xl">
                            </div>
                            <div class="bg-amber-400 rounded-2xl h-full overflow-hidden">
                                <img src="{{ asset('img/discount-promo-landscape-banner-template-design-b2d961494cf7721d73884d8a307ac771_screen.jpg') }}"
                                    alt="" class="w-full h-full object-cover rounded-2xl">
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Koleksi Terbaru --}}
                <section class="py-10 px-6 w-full mx-auto bg-white">
                    <div class="bg-neutral-50 max-w-7xl mx-auto rounded-md shadow-md border border-gray-200 p-6">
                        <div>
                            <h1 class="font-bold text-neutral-700 text-xl">Terbaru</h1>
                        </div>
                        <div class=" bg-gray-50 gap-4 p-4 grid grid-cols-6 mx-auto content-around">
                            @foreach ($latestBook as $book)
                                <a href="{{ route('show.book', $book) }}">
                                    <div
                                        class="book h-full bg-slate-50 rounded shadow border border-slate-300 cursor-pointer hover:scale-105 transition">
                                        <div class="h-fit bg-slate-400">
                                            <img src="{{ asset('storage/' . $book->cover) }}" alt=""
                                                class="shadow-sm">
                                        </div>

                                        <div class="p-3">
                                            <h2 class="font-bold text-sm">{{ $book->title }} ({{ $book->year }})</h2>
                                            <div class="text-xs">
                                                @foreach ($book->categories as $category)
                                                    <span class="">{{ $category->name }}, </span>
                                                @endforeach
                                            </div>
                                            <p class="text-xs font-semibold text-slate-500">Penulis: {{ $book->author }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>


                <!-- Bacaan Anda -->
                <section class="py-8 bg-gray-50">
                    <div class="max-w-5xl mx-auto px-6">
                        <h3 class="text-xl font-semibold mb-4">Bacaan Anda</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            {{-- @foreach ($books as $book)
                    <div class="bg-white p-2 rounded shadow">
                        <img src="{{ $book->cover }}" alt="{{ $book->title }}" class="w-full h-48 object-cover rounded">
                        <h4 class="mt-2 text-sm font-semibold">{{ $book->title }}</h4>
                        <p class="text-xs text-gray-500">Teknologi - {{ $book->published_at->format('d M Y') }}</p>
                    </div>
                @endforeach --}}
                        </div>
                    </div>
                </section>

                <!-- Buku Favorit -->
                <section class="py-8">
                    <div class="max-w-5xl mx-auto px-6">
                        <h3 class="text-xl font-semibold mb-4">Buku Favorit</h3>
                        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                            {{-- @foreach ($favoriteBooks as $book)
                    <div class="bg-white p-2 rounded shadow">
                        <img src="{{ $book->cover }}" alt="{{ $book->title }}" class="w-full h-48 object-cover rounded">
                        <h4 class="mt-2 text-sm font-semibold">{{ $book->title }}</h4>
                        <p class="text-xs text-gray-500">Teknologi - {{ $book->published_at->format('d M Y') }}</p>
                    </div>
                @endforeach --}}
                        </div>
                    </div>
                </section>

                <!-- Kegiatan Terbaru -->
                <section class="py-8 bg-gray-50">
                    <div class="max-w-5xl mx-auto px-6">
                        <h3 class="text-xl font-semibold mb-4">Kegiatan Terbaru</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- @foreach ($events as $event)
                    <div class="bg-white p-4 rounded shadow">
                        <img src="{{ $event->image }}" alt="{{ $event->title }}" class="w-full h-40 object-cover rounded mb-2">
                        <h4 class="text-base font-bold">{{ $event->title }}</h4>
                        <p class="text-sm text-gray-600 mb-2">{{ $event->excerpt }}</p>
                        <a href="{{ route('event.show', $event->slug) }}" class="text-blue-600 text-sm">Baca Selengkapnya</a>
                    </div>
                @endforeach --}}
                        </div>
                    </div>
                </section>
                <!-- Kegiatan Terbaru -->
                <section class="py-8 bg-gray-50">
                    <div class="max-w-5xl mx-auto px-6">
                        <h3 class="text-xl font-semibold mb-4">Visi dan Misi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, deleniti eveniet iure
                                impedit
                                recusandae alias, minima vel itaque suscipit pariatur perspiciatis eos cupiditate.
                                Possimus
                                corporis
                                delectus ratione quibusdam voluptatem natus!</p>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    @else
        @yield('content')
    @endif
    <x-footer-guest />
@endsection
