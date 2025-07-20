<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SOLIBRA - Perpustakaan Umum Kota Solok</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    <x-header-guest />

    @if (request()->is('/') || request()->is(app()->getLocale()) || request()->is('home'))
        <main>
            <div>
                <section
                    class="xl:flex grid w-full overflow-hidden shadow-lg bg-cover bg-no-repeat bg-center items-center justify-between 2xl:px-30 2xl:py-24 text-slate-50 text-shadow-md"
                    style="background-image: url({{ asset('img/Perpustakaan_Umum_Kota_Solok.jpg') }})">
                    <div class="md:p-10 lg:p-16 p-5">
                        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4">
                            <span class="block text-xl">
                                {{ __('message.welcome') }}
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



                <!-- Sambutan -->
                <section class="py-10 px-6 w-full mx-auto bg-white">
                    <div class="bg-neutral-50 max-w-7xl mx-auto rounded-md shadow-md border border-gray-200 p-6">
                        <h2
                            class="text-left text-2xl font-bold pb-7 mb-3 border-b border-neutral-200 max-w-fit mx-auto text-neutral-700">
                            Selamat
                            Datang di
                            Perpustakaan Umum Kota Solok
                        </h2>

                        <div class="border-l-4 border-l-yellow-500 p-5">
                            <p class="text-gray-700 leading-relaxed text-justify pl-1">
                                <strong class="text-neutral-700">Perpustakaan Umum Kota Solok</strong> adalah salah satu
                                lembaga
                                penting
                                di kota Solok, Sumatera
                                Barat,
                                yang berfungsi sebagai pusat pembelajaran dan pengembangan literasi di kalangan
                                masyarakat.
                                Dikenal dengan kota yang kaya akan budaya dan tradisi, Perpustakaan Kota Solok berperan
                                besar
                                dalam mendukung pembangunan pendidikan yang berkualitas, sekaligus memberikan akses bagi
                                warga
                                untuk memperoleh informasi dan pengetahuan yang mereka butuhkan. Sebagai lembaga
                                pendidikan
                                non-formal, perpustakaan ini terus berupaya untuk memperbaiki kualitas layanan dan
                                meningkatkan
                                minat baca masyarakat dari segala usia. Dalam artikel ini, kita akan membahas secara
                                mendalam
                                mengenai berbagai aspek yang ada di Perpustakaan Kota Solok, termasuk sejarah, visi dan
                                misi,
                                layanan, serta program-program unggulan yang mereka tawarkan.
                            </p>
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
</body>

</html>
