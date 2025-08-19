@extends('layouts.app')

@php
    $options = [
        ['status' => __('information.upcoming'), 'value' => 'upcoming'],
        ['status' => __('information.ongoing'), 'value' => 'ongoing'],
        ['status' => __('information.completed'), 'value' => 'completed'],
        ['status' => __('information.cancelled'), 'value' => 'cancelled'],
    ];

    $statusLabels = collect($options)->pluck('status', 'value');
@endphp

@section('content')
    <main class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4">

            <!-- Judul -->
            <div class="flex flex-col items-center text-center mb-14">
                <h2 class="text-3xl font-extrabold text-sky-800">{{ __('information.activity_information') }}</h2>
                <p class="text-gray-500 mt-2">{{ __('information.latest_activities') }}</p>
                <div class="w-20 border-b-4 border-sky-600 mt-3"></div>
            </div>

            <div class="block gap-6 text-sm items-center content-between" x-data="{ openNav: false }">
                <div @mouseenter="openNav=true" @mouseleave="openNav=false"
                    class="w-40 cursor-pointer bg-sky-50 border border-sky-200 rounded-md">
                    <span class="p-2 block text-center">{{ __('information.filter_information') }}</span>
                    <div x-show="openNav" x-transition class="border-t border-neutral-600 bg-sky-50 fixed w-40">
                        @foreach ($options as $option)
                            <div class="">
                                <a href="#"
                                    class="flex items-center gap-2 py-3 hover:text-neutral-50 px-3 hover:bg-sky-500 transition-all text-xs"
                                    :class="active === '{{ $option['value'] }}' ? 'text-sky-500' : ''">
                                    <span>{{ $option['status'] }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($informations as $index => $info)
                    <div class=" mt-4 info-card {{ $index >= 12 ? 'hidden' : '' }}">
                        <div
                            class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
                            <!-- Gambar -->
                            <div class="h-48 bg-gray-100">
                                <img src="{{ asset('storage/' . $info->images) }}" alt="Information Image"
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
                                    <a href="{{ route('show.information', $info->id) }}"
                                        class="text-gray-400 text-sm font-semibold hover:underline">
                                        {{ __('information.view_more') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Load More / Load Less Buttons -->
            @if ($informations->count() > 12)
                <div class="text-xs w-full flex justify-center mt-8 space-x-2">
                    <button id="load-less"
                        class="bg-white text-sky-800 px-4 py-2 border border-sky-800 rounded-3xl hover:bg-gray-100 hidden">
                        {{ __('information.load_less') }}
                    </button>
                    <button id="load-more"
                        class="bg-white text-sky-800 px-4 py-2 border border-sky-800 rounded-3xl hover:bg-gray-100">
                        {{ __('information.load_more') }}
                    </button>
                </div>
            @endif
        </div>
    </main>

    <script src="{{ asset('js/guest/profile.js') }}"></script>

    <!-- Script JS: Load More / Load Less -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
