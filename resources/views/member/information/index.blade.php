@extends('member.layouts.app')

@section('content')
    <main class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4">

            <!-- Judul -->
            <div class="flex flex-col items-center text-center mb-14">
                <h2 class="text-3xl font-extrabold text-sky-800">Informasi Kegiatan</h2>
                <p class="text-gray-500 mt-2">Kegiatan terbaru dari Perpustakaan Umum Kota Solok</p>
                <div class="w-20 border-b-4 border-sky-600 mt-3"></div>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($informations as $index => $info)
                    <div class=" mt-4 info-card {{ $index >= 12 ? 'hidden' : '' }}">
                        <div
                            class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
                            <!-- Gambar -->
                            <div class="h-48 bg-gray-100">
                                <img src="{{ asset('storage/' . $info->images) }}" alt="Gambar Informasi"
                                    class="w-full h-full object-cover">
                            </div>

                            <!-- Konten -->
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="text-lg text-sky-800 mb-1 hover:underline line-clamp-2 min-h-[3rem]">
                                    {{ $info->title }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-2 flex-grow line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($info->description), 100) }}
                                </p>
                                <div>
                                    <a href="{{ route('member.information.show', $info->id) }}"
                                        class="text-gray-400 text-sm font-semibold hover:underline">
                                        Lihat Selengkapnya →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Tombol Lihat Lebih Banyak / Sedikit -->
            @if ($informations->count() > 12)
                <div class="text-xs w-full flex justify-center mt-8 space-x-2">
                    <button id="load-less"
                        class="bg-white text-sky-800 px-4 py-2 border border-sky-800 rounded-3xl hover:bg-gray-100 hidden">
                        Lihat Lebih Sedikit
                    </button>
                    <button id="load-more"
                        class="bg-white text-sky-800 px-4 py-2 border border-sky-800 rounded-3xl hover:bg-gray-100">
                        Lihat Lebih Banyak
                    </button>
                </div>
            @endif
        </div>
    </main>

    <script src="{{ asset('js/guest/profile.js') }}"></script>

    <!-- Script JS: Load More / Load Less -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const cards = document.querySelectorAll(".info-card");
            const loadMore = document.getElementById("load-more");
            const loadLess = document.getElementById("load-less");

            let visible = 12;

            loadMore.addEventListener("click", () => {
                visible += 12;
                cards.forEach((card, i) => {
                    if (i < visible) card.classList.remove("hidden");
                });

                if (visible >= cards.length) {
                    loadMore.classList.add("hidden");
                }

                loadLess.classList.remove("hidden");
            });

            loadLess.addEventListener("click", () => {
                visible = 12;
                cards.forEach((card, i) => {
                    if (i >= visible) card.classList.add("hidden");
                });

                loadMore.classList.remove("hidden");
                loadLess.classList.add("hidden");
            });
        });
    </script>
@endsection
