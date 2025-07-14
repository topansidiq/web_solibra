@extends('member.layouts.app')

@section('content')
    <section
        class="w-full h-[420px] overflow-hidden shadow-lg rounded-md bg-cover bg-no-repeat bg-center flex items-center justify-between px-40 text-slate-50 text-shadow-md"
        style="background-image: url({{ asset('img/perpustakaan_umum.jpg') }})">
        <div class="">
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
                <span>
                    Perpustakaan<br>Umum Kota Solok
                </span>
            </h1>
            <div class="flex gap-4">
                <a href="#"
                    class=" bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-full shadow-md transition duration-300">
                    Hubungi Kami
                </a>
                <a href="#"
                    class="bg-slate-700 hover:bg-slate-900 text-white px-5 py-2 rounded-full shadow-md transition duration-300">
                    Bergabung
                </a>
            </div>
        </div>
        <div class="">
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
                <span>
                    Halo, {{ $user->name }}
                </span>
            </h1>
        </div>
    </section>



    <!-- Sambutan -->
    <section class="py-10 px-6 max-w-5xl mx-auto">
        <div class="bg-white rounded-md shadow-md border border-gray-200 p-6">
            <h2 class="text-center text-2xl font-bold mb-2">Selamat Datang di Perpustakaan Umum Kota Solok</h2>
            <div class="w-20 h-[3px] bg-gray-300 mx-auto mb-6 rounded-full"></div>

            <p class="text-gray-700 leading-relaxed text-justify">
                Perpustakaan Umum Kota Solok adalah salah satu lembaga penting di kota Solok, Sumatera Barat,
                yang berfungsi sebagai pusat pembelajaran dan pengembangan literasi di kalangan masyarakat.
                Dikenal dengan kota yang kaya akan budaya dan tradisi, Perpustakaan Kota Solok berperan besar
                dalam mendukung pembangunan pendidikan yang berkualitas, sekaligus memberikan akses bagi warga
                untuk memperoleh informasi dan pengetahuan yang mereka butuhkan. Sebagai lembaga pendidikan
                non-formal, perpustakaan ini terus berupaya untuk memperbaiki kualitas layanan dan meningkatkan
                minat baca masyarakat dari segala usia. Dalam artikel ini, kita akan membahas secara mendalam
                mengenai berbagai aspek yang ada di Perpustakaan Kota Solok, termasuk sejarah, visi dan misi,
                layanan, serta program-program unggulan yang mereka tawarkan.
            </p>
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
@endsection
