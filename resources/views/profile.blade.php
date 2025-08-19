@extends('layouts.app')

@section('title', __('main.navigation.profile') . ' | Perpustakaan Umum Kota Solok')

@section('content')
    <main>
        <div>
            <div class="w-full relative mx-auto overflow-hidden rounded-lg shadow-lg" x-data="carousel()"
                x-init="start()">
                <!-- Slides -->
                <div class="relative h-96">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="active === index" class="absolute inset-0 transition-opacity duration-700 ease-in-out"
                            x-transition:enter="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
                            <img :src="slide.image" class="w-full h-full object-cover" :alt="'Slide ' + (index + 1)">
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
            <section class="py-16 px-2 sm:px-4 lg:px-6 w-full mx-auto bg-white">
                <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div>
                        <h2 class="text-4xl font-semibold text-gray-900 mb-3 leading-snug">
                            {!! __('profile.welcome') !!}
                        </h2>
                    </div>

                    <div>
                        <p class="text-gray-700 text-lg leading-relaxed mb-7">
                            {{ __('profile.preface') }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- Sejahtera -->
            <section class="py-16 px-2 sm:px-4 lg:px-6 w-full mx-auto bg-neutral-100">
                <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div>
                        <h2 class="text-4xl font-semibold text-gray-900 mb-3 leading-snug">
                            {!! __('profile.history') !!}
                        </h2>
                    </div>

                    <div class="text-gray-700 text-lg leading-relaxed space-y-4">
                        <p>
                            {{ __('profile.history_content.p1') }}
                        </p>
                        <p>
                            {{ __('profile.history_content.p2') }}
                        </p>
                        <p>
                            {{ __('profile.history_content.p3') }}
                        </p>
                        <p>
                            {{ __('profile.history_content.p4') }}
                        </p>
                    </div>

                </div>
            </section>

            {{-- Visi Misi --}}
            <section class="py-16 px-2 sm:px-4 lg:px-6 w-full mx-auto bg-white">
                <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div>
                        <h2 class="text-4xl font-semibold text-gray-900 mb-3 leading-snug">
                            {!! __('profile.vision_mission') !!}
                        </h2>
                    </div>

                    <div>
                        <p class="text-gray-700 text-lg leading-relaxed mb-7">
                            {{ __('profile.vision_mission_content.p1') }}
                        </p>

                        <p class="text-gray-700 text-lg leading-relaxed mb-7 italic font-semibold">
                            {{ __('profile.vision_mission_content.p2') }}
                        </p>

                        <p class="text-gray-700 text-lg leading-relaxed mb-7">
                            {{ __('profile.vision_mission_content.p3') }}
                        </p>

                        <ul class="list-decimal ml-8 text-gray-700 text-lg leading-relaxed text-justify space-y-2 mb-7">
                            {!! __('profile.vision_mission_content.p4') !!}
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script src="{{ asset('js/guest/profile.js') }}"></script>
@endsection
