@extends('member.layouts.app')

@section('content')
<main>
    <!-- Carousel -->
    <div class="w-full relative mx-auto overflow-hidden rounded-lg shadow-lg mb-8" x-data="carousel()" x-init="start()">
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

        <div class="absolute inset-0 flex justify-between items-center px-4">
            <button @click="prev()" class="bg-black/30 hover:bg-black/50 text-white px-2 py-1 rounded-full">&larr;</button>
            <button @click="next()" class="bg-black/30 hover:bg-black/50 text-white px-2 py-1 rounded-full">&rarr;</button>
        </div>

        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="active = index" :class="active === index ? 'bg-white' : 'bg-white/50'"
                    class="w-2 h-2 rounded-full"></button>
            </template>
        </div>
    </div>

    <!-- Informasi Kegiatan-->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center mb-10">
            <h2 class="text-3xl font-extrabold text-sky-800">Informasi Kegiatan</h2>
            <p class="text-gray-500 mt-2">Kegiatan terbaru dari Perpustakaan Umum Kota Solok</p>
            <div class="w-20 border-b-4 border-sky-600 mt-3"></div>
        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach ($informations as $index => $info)
                <div class="info-card {{ $index >= 5 ? 'hidden' : '' }}">
                    <div class="relative bg-white shadow-md rounded-lg overflow-hidden group h-[200px] md:h-[300px] lg:h-[400px]">
                        <img src="{{ asset('storage/' . $info->images) }}"
                            alt="Gambar Informasi"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

                        <div class="absolute inset-0 bg-gradient-to-t from-sky-800 via-transparent to-transparent opacity-60"></div>

                        <div class="absolute bottom-0 p-4 text-white">
                            <h3 class="text-xl font-bold text-shadow-lg">{{ $info->title }}</h3>
                            <p class="mt-3 text-sm text-gray-200 mb-3">
                                {{ \Illuminate\Support\Str::limit(strip_tags($info->description), 50) }}
                            </p>
                            <a href="{{ route('member.information.show', $info->id) }}"
                            class="inline-block bg-gray-300 text-sky-800 text-sm font-semibold px-3 py-1 rounded hover:bg-gray-400 transition">
                                Lihat Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Tombol Lihat Lebih Banyak / Sedikit -->
        <div class="w-full flex justify-center mt-8 space-x-4">
            <button id="load-more" class="bg-sky-700 text-white px-4 py-2 rounded hover:bg-sky-800">
                Lihat Lebih Banyak
            </button>
            <button id="load-less" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 hidden">
                Lihat Lebih Sedikit
            </button>
        </div>
    </div>
</main>

<script src="{{ asset('js/guest/profile.js') }}"></script>

<!-- Script JS: Load More / Load Less -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cards = document.querySelectorAll(".info-card");
        const loadMore = document.getElementById("load-more");
        const loadLess = document.getElementById("load-less");

        let visible = 5;

        loadMore.addEventListener("click", () => {
            visible += 5;
            cards.forEach((card, i) => {
                if (i < visible) card.classList.remove("hidden");
            });

            if (visible >= cards.length) {
                loadMore.classList.add("hidden");
            }

            loadLess.classList.remove("hidden");
        });

        loadLess.addEventListener("click", () => {
            visible = 5;
            cards.forEach((card, i) => {
                if (i >= visible) card.classList.add("hidden");
            });

            loadMore.classList.remove("hidden");
            loadLess.classList.add("hidden");
        });
    });
</script>
@endsection
