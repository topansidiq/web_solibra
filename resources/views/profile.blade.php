<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOLIBRA - Perpustakaan Umum Kota Solok</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    <x-header-guest />
    <main>
        <div>
            <div class="w-full relative mx-auto overflow-hidden rounded-lg shadow-lg" x-data="carousel()"
                x-init="start()">
                <!-- Slides -->
                <div class="relative h-96">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="active === index"
                            class="absolute inset-0 transition-opacity duration-700 ease-in-out"
                            x-transition:enter="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
                            <img :src="slide.image" class="w-full h-full object-cover"
                                :alt="'Slide ' + (index + 1)">
                        </div>
                    </template>
                </div>

                <!-- Navigasi manual (opsional) -->
                <div class="absolute inset-0 flex justify-between items-center px-4">
                    <button @click="prev()" class="bg-black/30 hover:bg-black/50 text-white px-2 py-1 rounded-full">
                        &larr;
                    </button>
                    <button @click="next()" class="bg-black/30 hover:bg-black/50 text-white px-2 py-1 rounded-full">
                        &rarr;
                    </button>
                </div>

                <!-- Indicator -->
                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-2">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="active = index" :class="active === index ? 'bg-white' : 'bg-white/50'"
                            class="w-2 h-2 rounded-full">
                        </button>
                    </template>
                </div>
            </div>



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
    <x-footer-guest />

    <script src="{{ asset('js/guest/profile.js') }}"></script>
</body>

</html>
