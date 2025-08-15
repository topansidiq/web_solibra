@php
    $menu = [
        ['label' => 'Beranda', 'name' => 'home'],
        ['label' => 'Koleksi', 'name' => 'collection'],
        ['label' => 'Profil', 'name' => 'profile'],
        ['label' => 'Layanan', 'name' => 'service'],
        ['label' => 'Kegiatan', 'name' => 'event'],
        ['label' => 'Informasi', 'name' => 'information'],
        ['label' => 'Galeri', 'name' => 'gallery'],
    ];
@endphp

<div class="w-full grid items-center xl:flex sticky top-0 z-50 bg-sky-800 text-slate-50" x-data="{ active: '{{ Route::currentRouteName() }}' }"
    x-transition>

    <div class="xl:p-4 flex justify-between gap-5 w-full">
        <div class="p-3 flex gap-2 items-center pb-2">
            <div class="w-8 h-8 bg-yellow-500 flex items-center justify-center">
                <i data-lucide="library" class="w-auto text-neutral-800"></i>
            </div>
            <div>
                <p class="font-serif">SOLIBRA</p>
                <p class="text-xs">Perpustakaan Umum Kota Solok</p>
            </div>
        </div>

        {{-- Desktop --}}
        <nav class="hidden xl:flex gap-6 text-sm items-center content-between" x-data="{ openDropDown: false, active: '{{ request()->route()->getName() }}' }">

            @foreach ($menu as $item)
                <div @mouseenter="openDropDown = '{{ $item['name'] }}'" @mouseleave="openDropDown = false" x-transition
                    x-cloak class="relative">

                    <a href="{{ route($item['name']) }}" @click="active = '{{ $item['name'] }}'"
                        class="py-2 hover:text-yellow-500 hover:border-b-yellow-500 hover:border-b transition-all text-xs"
                        :class="active === '{{ $item['name'] }}' ? 'border-b border-b-gray-50' : ''">
                        <span>{{ $item['label'] }}</span>
                    </a>

                    @if ($item['name'] === 'event')
                        @php
                            $options = [
                                ['status' => 'Akan Datang', 'value' => 'upcoming'],
                                ['status' => 'Sedang Berlangsung', 'value' => 'ongoing'],
                                ['status' => 'Sudah Selesai', 'value' => 'completed'],
                                ['status' => 'Dibatalkan', 'value' => 'cancelled'],
                            ];
                        @endphp

                        <div class="absolute top-full left-0 mt-2 bg-neutral-50 text-neutral-700 shadow-lg w-48 z-50 border border-neutral-500 rounded-md text-sm"
                            x-show="openDropDown === 'event'" x-transition x-cloak>
                            @foreach ($options as $opt)
                                <a href="{{ route('event') }}"
                                    class="block px-4 py-2 hover:bg-yellow-500 hover:text-white">
                                    {{ $opt['status'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    @if ($item['name'] === 'collection')
                        <div class="absolute top-full left-0 mt-2 bg-neutral-50 text-neutral-700 shadow-lg w-48 z-50 border border-neutral-500 rounded-md text-sm"
                            x-show="openDropDown === 'collection'" x-transition x-cloak>
                            @foreach ($categories ?? [] as $category)
                                @if (is_object($category))
                                    <a href="{{ route('collection', ['category' => $category->slug ?? $category->id]) }}"
                                        class="block px-4 py-2 hover:bg-yellow-500 hover:text-white">
                                        {{ $category->name }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </nav>

        @php
            use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
        @endphp
        <div class="profile hidden lg:flex gap-3 items-center p-3">
            <ul class="flex gap-3">
                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    @php
                        $flag = match ($properties['native']) {
                            'Bahasa Indonesia' => 'indonesia_flag.png',
                            'English' => 'uk_flag.png',
                            default => null,
                        };
                    @endphp

                    @if ($flag)
                        <li>
                            <a rel="alternate" hreflang="{{ $localeCode }}"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                <img src="{{ asset('img/' . $flag) }}" alt="{{ $properties['native'] }} flag"
                                    class="w-6">
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>

            <div class="login flex gap-3">
                <div class="bg-yellow-500 px-4 py-1 rounded text-sm">
                    <a href="/login" class="text-shadow-md">Masuk</a>
                </div>
            </div>
            <div class="register flex gap-3">
                <div class="bg-sky-500 px-4 py-1 rounded text-sm">
                    <a href="/register" class="text-shadow-md">Bergabung</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile --}}
    <nav class="block xl:hidden gap-6 text-sm items-center content-between" x-data="{ openNav: false }">
        <button @click="openNav=!openNav" class="p-3">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>

        <div x-show="openNav" x-transition class="border-t border-neutral-600">
            @foreach ($menu as $item)
                <div>
                    <a href="{{ route($item['name']) }}" @click="active = '{{ $item['name'] }}'"
                        class="flex items-center gap-2 py-3 hover:text-neutral-50 px-3 hover:bg-amber-500 transition-all text-xs"
                        :class="active === '{{ $item['name'] }}' ? 'text-amber-500' : ''">
                        <span>{{ $item['label'] }}</span>
                    </a>
                </div>
            @endforeach

            <div class="p-3 pb-5 profile flex lg:hidden gap-3 items-center border-t border-neutral-600">
                <div class="login flex gap-3">
                    <div class="bg-red-500 px-4 py-1 rounded">
                        <a href="/login">Login</a>
                    </div>
                </div>
            </div>
        </div>

        <ul class="flex gap-3">
            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                @php
                    $flag = match ($properties['native']) {
                        'Bahasa Indonesia' => 'indonesia_flag.png',
                        'English' => 'uk_flag.png',
                        default => null,
                    };
                @endphp

                @if ($flag)
                    <li>
                        <a rel="alternate" hreflang="{{ $localeCode }}"
                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            <img src="{{ asset('img/' . $flag) }}" alt="{{ $properties['native'] }} flag"
                                class="w-6">
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </nav>
</div>
