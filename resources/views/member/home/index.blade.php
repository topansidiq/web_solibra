@extends('member.layouts.app')

@section('title', __('main.navigation.home') . ' | Perpustakaan Umum Kota Solok')

@section('content')
    {{-- @if (request()->is('/') || request()->is('home')) --}}
    <main>
        <script src="{{ asset('js/guest/home.js') }}"></script>
        <div class="grid">
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

            {{-- Dashboard --}}
            <section class="py-5 px-6 w-full bg-white max-w-[1680px] mx-auto">
                <div class="border border-neutral-200 rounded-xl">
                    {{-- Activity --}}
                    <div class="py-3">
                        <div class="px-5 font-bold text-neutral-700 text-xl">{{ __('home.activity') }}</div>
                        <div class="p-5 gap-3 justify-between" x-data="{ showActiveBorrow: false, showOverdueBorrow: false, showUnconfirmedBorrow: false, showArchiveBorrow: false }">
                            <div class="md:grid grid-cols-4 gap-3 flex flex-col">
                                {{-- Active Borrow --}}
                                <div>
                                    <h1 class="text-sm font-semibold mb-3 flex items-center gap-3">
                                        <i data-lucide="circle" class="fill-green-500 text-green-500 w-3 h-3"></i>
                                        <p>{{ __('home.active_borrow') }}</p>
                                    </h1>
                                    <div class="rounded-md shadow-md p-2 border border-neutral-200">
                                        <div>
                                            <div class="p-4 flex items-center justify-between">
                                                <div class="text-4xl">
                                                    {{ $borrows['active']->count() }}
                                                </div>
                                                @if ($borrows['active']->count() > 0)
                                                    <div class="text-sm text-neutral-500">
                                                        {{ __('home.due_on') }}
                                                        {{ $borrows['active']->first()->due_date->format('d-m-Y') }}
                                                    </div>
                                                @endif
                                            </div>

                                            @if ($borrows['active']->count() > 0)
                                                <div @click="showActiveBorrow=true"
                                                    class="px-2 py-1 text-left bg-white p-2 text-sm rounded-md border border-neutral-200 hover:bg-neutral-700 hover:text-neutral-50 cursor-pointer">
                                                    <button>{{ __('home.view_active_borrow') }}</button>
                                                </div>

                                                <div class="grid gap-2 p-3" x-show="showActiveBorrow">
                                                    <div class="flex items-center justify-between">
                                                        <p style="font-size: 12px" class="font-bold text-neutral-500">
                                                            {{ __('home.active_borrow') }}</p>
                                                        <button @click="showActiveBorrow=false" style="font-size: 12px"
                                                            class="text-sky-500 font-semibold">{{ __('home.close') }}</button>
                                                    </div>
                                                    <div class="flex items-center gap-3">
                                                        <p class="font-bold text-sm">NP</p>
                                                        <p class="font-bold text-sm">Data</p>
                                                    </div>
                                                    @foreach ($borrows['active'] as $borrow)
                                                        <div class="flex items-start gap-3 hover:scale-105 transition-all">
                                                            <div class="text-sm font-bold">{{ $borrow->id }}</div>
                                                            <div>
                                                                <p class="text-sm">{{ $borrow->book->clean_title }}</p>
                                                                <p class="text-xs font-semibold text-neutral-500">
                                                                    {{ __('home.due_on') }} {{ $borrow->due_date->diffForHumans() }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p
                                                    class="px-2 py-1 text-left bg-white p-2 text-sm rounded-md border border-neutral-200">
                                                    {{ __('home.no_active_borrow') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Overdue Borrow --}}
                                <div>
                                    <h1 class="text-sm font-semibold mb-3 flex items-center gap-3">
                                        <i data-lucide="circle" class="fill-red-500 text-red-500 w-3 h-3"></i>
                                        <p>{{ __('home.overdue_borrow') }}</p>
                                    </h1>
                                    <div class="rounded-md shadow-md p-2 border border-neutral-200">
                                        <div>
                                            <div class="p-4 flex items-center justify-between">
                                                <div class="text-4xl">{{ $borrows['overdue']->count() }}</div>
                                                @if ($borrows['overdue']->count() > 0)
                                                    <div class="text-sm text-neutral-500">
                                                        {{ __('home.overdue_days', ['days' => $borrows['overdue']->first()->due_date->diffInDays(now())]) }}
                                                    </div>
                                                @endif
                                            </div>

                                            @if ($borrows['overdue']->count() > 0)
                                                <div @click="showOverdueBorrow=true"
                                                    class="px-2 py-1 text-left bg-white p-2 text-sm rounded-md border border-neutral-200 hover:bg-neutral-700 hover:text-neutral-50 cursor-pointer">
                                                    <button>{{ __('home.view_overdue_borrow') }}</button>
                                                </div>

                                                <div class="grid gap-2 p-3" x-show="showOverdueBorrow">
                                                    <div class="flex items-center justify-between">
                                                        <p style="font-size: 12px" class="font-bold text-neutral-500">
                                                            {{ __('home.overdue_borrow') }}</p>
                                                        <button @click="showOverdueBorrow=false" style="font-size: 12px"
                                                            class="text-sky-500 font-semibold">{{ __('home.close') }}</button>
                                                    </div>
                                                    <div class="flex items-center gap-3">
                                                        <p class="font-bold text-sm">NP</p>
                                                        <p class="font-bold text-sm">Data</p>
                                                    </div>
                                                    @foreach ($borrows['overdue'] as $borrow)
                                                        <div class="flex items-start gap-3 hover:scale-105 transition-all">
                                                            <div class="text-sm font-bold">{{ $borrow->id }}</div>
                                                            <div>
                                                                <p class="text-sm">{{ $borrow->book->clean_title }}</p>
                                                                <p class="text-xs font-semibold text-neutral-500">
                                                                    {{ __('home.due_on') }} {{ $borrow->due_date->diffForHumans() }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p
                                                    class="px-2 py-1 text-left bg-white p-2 text-sm rounded-md border border-neutral-200">
                                                    {{ __('home.no_overdue_borrow') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Pending Borrow --}}
                                <div>
                                    <h1 class="text-sm font-semibold mb-3 flex items-center gap-3">
                                        <i data-lucide="circle" class="fill-yellow-500 text-yellow-500 w-3 h-3"></i>
                                        <p>{{ __('home.pending_borrow') }}</p>
                                    </h1>
                                    <div class="rounded-md shadow-md p-2 border border-neutral-200 text-4xl">
                                        <div>
                                            <div class="p-4 flex items-center justify-between">
                                                <div>{{ $borrows['pending']->count() }}</div>
                                                @if ($borrows['pending']->count() > 0)
                                                    <div class="text-sm text-neutral-500">
                                                        {{ __('home.submitted_on') }}
                                                        {{ $borrows['pending']->first()->borrowed_at->format('d-m-Y') }}
                                                    </div>
                                                @endif
                                            </div>

                                            @if ($borrows['pending']->count() > 0)
                                                <div @click="showUnconfirmedBorrow=true"
                                                    class="px-2 py-1 text-left bg-white p-2 text-sm rounded-md border border-neutral-200 hover:bg-neutral-700 hover:text-neutral-50 cursor-pointer">
                                                    <button>{{ __('home.view_pending_borrow') }}</button>
                                                </div>

                                                <div class="grid gap-2 p-3" x-show="showUnconfirmedBorrow">
                                                    <div class="flex items-center justify-between">
                                                        <p style="font-size: 12px" class="font-bold text-neutral-500">
                                                            {{ __('home.pending_borrow') }}</p>
                                                        <button @click="showUnconfirmedBorrow=false" style="font-size: 12px"
                                                            class="text-sky-500 font-semibold">{{ __('home.close') }}</button>
                                                    </div>
                                                    <div class="flex items-center gap-3">
                                                        <p class="font-bold text-sm">NP</p>
                                                        <p class="font-bold text-sm">Data</p>
                                                    </div>
                                                    @foreach ($borrows['pending'] as $borrow)
                                                        <div class="flex items-start gap-3 hover:scale-105 transition-all">
                                                            <div class="text-sm font-bold">{{ $borrow->id }}</div>
                                                            <div>
                                                                <p class="text-sm">{{ $borrow->book->clean_title }}</p>
                                                                <p class="text-xs font-semibold text-neutral-500">
                                                                    {{ __('home.due_on') }} {{ $borrow->due_date->diffForHumans() }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p
                                                    class="px-2 py-1 text-left bg-white p-2 text-sm rounded-md border border-neutral-200">
                                                    {{ __('home.no_pending_borrow') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Archive Borrow --}}
                                <div>
                                    <h1 class="text-sm font-semibold mb-3 flex items-center gap-3">
                                        <i data-lucide="circle" class="fill-sky-500 text-sky-500 w-3 h-3"></i>
                                        <p>{{ __('home.archive_borrow') }}</p>
                                    </h1>
                                    <div class="rounded-md shadow-md p-2 border border-neutral-200 text-4xl">
                                        <div>
                                            <div class="p-4 flex items-center justify-between">
                                                <div>{{ $borrows['archive']->count() }}</div>
                                                @if ($borrows['archive']->count() > 0)
                                                    <div class="text-sm text-neutral-500">
                                                        {{ __('home.returned_on') }}
                                                        {{ $borrows['archive']->first()->return_date->format('d-m-Y') }}
                                                    </div>
                                                @endif
                                            </div>

                                            @if ($borrows['archive']->count() > 0)
                                                <div @click="showArchiveBorrow=true"
                                                    class="px-2 py-1 text-left bg-white p-2 text-sm rounded-md border border-neutral-200 hover:bg-neutral-700 hover:text-neutral-50 cursor-pointer">
                                                    <button>{{ __('home.view_archive_borrow') }}</button>
                                                </div>

                                                <div class="grid gap-2 p-3" x-show="showArchiveBorrow">
                                                    <div class="flex items-center justify-between">
                                                        <p style="font-size: 12px" class="font-bold text-neutral-500">
                                                            {{ __('home.archive_borrow') }}</p>
                                                        <button @click="showArchiveBorrow=false" style="font-size: 12px"
                                                            class="text-sky-500 font-semibold">{{ __('home.close') }}</button>
                                                    </div>
                                                    <div class="flex items-center gap-3">
                                                        <p class="font-bold text-sm">NP</p>
                                                        <p class="font-bold text-sm">Data</p>
                                                    </div>
                                                    @foreach ($borrows['archive'] as $borrow)
                                                        <div class="flex items-start gap-3 hover:scale-105 transition-all">
                                                            <div class="text-sm font-bold">{{ $borrow->id }}</div>
                                                            <div>
                                                                <p class="text-sm">{{ $borrow->book->clean_title }}</p>
                                                                <p class="text-xs font-semibold text-neutral-500">
                                                                    {{ __('home.returned_on') }}
                                                                    {{ $borrows['archive']->first()->return_date->diffForHumans() }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p
                                                    class="px-2 py-1 text-left bg-white p-2 text-sm rounded-md border border-neutral-200">
                                                    {{ __('home.no_archive_borrow') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Collection --}}
                    <div class="py-3">
                        <div class="px-5 font-bold text-neutral-700 text-xl">{{ __('home.your_collection') }}</div>
                    </div>
                </div>
            </section>

            {{-- Beranda --}}
            <section class="py-5 px-6 w-full bg-white">

                <div class="hidden md:grid grid-rows-2 grid-cols-3 md:max-w-7xl max-h-80 mx-auto justify-center gap-4">

                    <div class="col-span-2 row-span-2 rounded-2xl md:relative overflow-hidden shadow-md border border-neutral-200"
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
                            }" x-init="startAutoplay()" @mouseenter="stopAutoplay" @mouseleave="startAutoplay">
                        <!-- Slides -->
                        <template x-for="(media, index) in {{ json_encode($latestMedia) }}" :key="index">
                            <div x-show="currentIndex === index" x-transition.opacity.duration.500ms
                                class="md:absolute inset-0">

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
                                <div class="w-full text-sm text-center py-2 rounded-b-2xl z-30">
                                    <span>Terbaru</span>
                                </div>
                            </div>
                        </template>

                        <!-- Tombol navigasi -->
                        <button @click="currentIndex = (currentIndex - 1 + total) % total"
                            class="md:absolute left-3 top-1/2 -translate-y-1/2 bg-black bg-opacity-40 text-white rounded-full w-8 h-8 flex items-center justify-center">
                            ‹
                        </button>
                        <button @click="currentIndex = (currentIndex + 1) % total"
                            class="md:absolute right-3 top-1/2 -translate-y-1/2 bg-black bg-opacity-40 text-white rounded-full w-8 h-8 flex items-center justify-center">
                            ›
                        </button>

                        <!-- Indicator -->
                        <div class="md:absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2">
                            <template x-for="(media, index) in {{ json_encode($latestMedia) }}" :key="'dot-' + index">
                                <div @click="currentIndex = index"
                                    :class="currentIndex === index ? 'bg-white' : 'bg-gray-400'"
                                    class="w-3 h-3 rounded-full cursor-pointer ring-1 ring-gray-300 transition"></div>
                            </template>
                        </div>
                    </div>

                    <!-- Banner kanan atas -->
                    <div class="col-auto row-auto md:relative shadow-md border border-neutral-200 rounded-2xl">
                        @if ($newItem['book'])
                            <img src="{{ asset('storage/' . $newItem['book']->cover) }}" alt=""
                                class="w-full h-full object-cover rounded-2xl">
                            <div
                                class="md:absolute bottom-0 w-full bg-gradient-to-t from-black/80 via-black/50 to-transparent text-white text-sm text-center py-1 rounded-b-2xl">
                                <div class="flex items-center justify-between px-5 py-3">
                                    <a href="{{ route('show.book', $newItem['book']) }}"
                                        class="block px-2 py-1 rounded-md text-sm bg-sky-500 text-neutral-50">Lihat
                                        Detail</a>
                                    <span class="block">Buku Terbaru</span>
                                </div>
                            </div>
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-t from-black/80 via-black/50 to-transparent rounded-2xl flex items-center justify-center">
                                <span class="text-gray-900 z-50">No Book</span>
                            </div>
                        @endif
                    </div>

                    <!-- Banner kanan bawah -->
                    <div class="col-auto row-auto md:relative shadow-md border border-neutral-200 rounded-2xl">
                        @if ($newItem['event'])
                            <img src="{{ asset('storage/' . $newItem['event']->poster) }}" alt=""
                                class="w-full h-full object-cover rounded-2xl">
                            <div
                                class="absolute bottom-0 w-full  bg-gradient-to-t from-black/80 via-black/50 to-transparent text-white text-sm text-center py-1 rounded-b-2xl">
                                <div class="flex items-center justify-between px-5 py-3">
                                    <a href="{{ route('event', $newItem['event']) }}"
                                        class="block px-2 py-1 rounded-md text-sm bg-sky-500 text-neutral-50">Lihat
                                        Detail</a>
                                    <span class="block">Kegiatan Terbaru</span>
                                </div>
                            </div>
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-t from-black/80 via-black/50 to-transparent rounded-2xl flex items-center justify-center">
                                <span class="text-gray-500 z-50">No Event</span>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- Latest Collection --}}
            <section class="md:py-1 px-2 w-full mx-auto bg-white border-t border-neutral-100">
    <div class="max-w-7xl mx-auto p-2">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-bold text-neutral-700 text-xl">{{ __('home.recommendation') }}</h1>
                <p class="text-xs">{{ __('home.recommendation_message') }}</p>
            </div>
            <div class="flex gap-3">
                <div class="rounded-md px-1 py-0.5 text-xs bg-sky-200">
                    <a href="#">{{ __('home.recommendation_button') }}</a>
                </div>
                <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200 text-center">
                    <a href="#">Teknologi</a>
                </div>
                <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200 text-center">
                    <a href="#">Sejarah</a>
                </div>
                <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200 text-center">
                    <a href="#">Religi</a>
                </div>
                <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200 text-center">
                    <a href="#">Novel</a>
                </div>
            </div>
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
                            <h2 class="font-bold text-sm">{{ $book->clean_title }} ({{ $book->year }})</h2>
                            <div class="text-xs">
                                @foreach ($book->categories as $category)
                                    <span>{{ $category->name }}@if (!$loop->last),@endif</span>
                                @endforeach
                            </div>
                            <p class="text-xs font-semibold text-slate-500">{{ __('home.author') }}: {{ $book->formatted_author }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

            {{-- Popular Collection --}}
            <section class="md:py-1 px-2 w-full mx-auto bg-white border-t border-neutral-100">
                <div class="max-w-7xl mx-auto p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="font-bold text-neutral-700 text-xl">{{ __('home.popular') }}</h1>
                            <p class="text-xs">{{ __('home.popular_message') }}</p>
                        </div>
                        <div class="flex gap-3">
                            <div class="rounded-md px-1 py-0.5 text-xs bg-sky-200">
                                <a href="#">{{ __('home.popular_button') }}</a>
                            </div>
                            <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200 text-center">
                                <a href="#">2024</a>
                            </div>
                            <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200 text-center">
                                <a href="#">2023</a>
                            </div>
                        </div>
                    </div>
                    <div
                    class=" gap-4 xl:p-4 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6 mx-auto content-around">
                        @foreach ($latestBook as $book)
                            <a href="{{ route('show.book', $book) }}">
                                <div
                                class="book h-full bg-slate-50 rounded-md shadow border border-slate-300 cursor-pointer hover:scale-105 transition">

                                    @if ($book->cover && Storage::disk('public')->exists($book->cover))
                                        <div class="h-72"
                                        style="background-image: url({{ asset('storage/' . $book->cover) }})"></div>
                                    @else
                                        <div class="h-72 bg-cover bg-no-repeat py-10 flex items-center justify-center text-white text-2xl font-semibold"
                                            style="background-image: url({{ asset('img/default_cover.jpg') }})">
                                            <h1 class="p-3">{{ $book->clean_title }}</h1>
                                        </div>
                                    @endif

                                    <div class="p-3">
                                        <h2 class="font-bold text-sm">{{ $book->clean_title }} ({{ $book->year }})</h2>
                                        <div class="text-xs">
                                            @foreach ($book->categories as $category)
                                                <span>{{ $category->name }}@if (!$loop->last),@endif</span>
                                            @endforeach
                                        </div>
                                        <p class="text-xs font-semibold text-slate-500">{{ __('home.author') }}: {{ $book->formatted_author }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Latest Event --}}
            <section class="md:py-1 px-2 w-full mx-auto bg-white border-t border-neutral-100">
                <div class="max-w-7xl mx-auto p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="font-bold text-neutral-700 text-xl">{{ __('home.event') }}</h1>
                            <p class="text-xs">{{ __('home.event_message') }}</p>
                        </div>
                        <div class="flex gap-3">
                            <div class="rounded-md px-1 py-0.5 text-xs bg-sky-200">
                                <a href="#">{{ __('home.event_buttons.ongoing') }}</a>
                            </div>
                            <div class="rounded-md px-1 py-0.5 text-xs bg-neutral-200 text-center">
                                <a href="#">{{ __('home.event_buttons.upcoming') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="gap-4 xl:p-4 grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-3 mx-auto content-around">
                        @if ($latestEvent->isEmpty())
                            <p class="text-black">{{ __('home.no_event') }}</p>
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
                                            <h2 class="font-bold text-sm">{{ $event->title }} ({{ $event->start_at }})</h2>
                                            <p class="text-xs font-semibold text-slate-500">{{ $event->status }}</p>
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
