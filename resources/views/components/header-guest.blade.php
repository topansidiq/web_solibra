<div class="w-full grid items-center xl:flex sticky top-0 z-50 bg-sky-800 text-slate-50" x-data="{ active: '{{ Route::currentRouteName() }}' }"
    x-transition>
    <div class="xl:p-4 flex justify-between gap-5 w-full">
        <div class="p-3 flex gap-2 items-center pb-2">
            <div class="w-8 h-8 bg-yellow-500">
                <i data-lucide="library" class="w-auto text-neutral-800"></i>
            </div>
            <div class="">
                <p class="font-serif">SOLIBRA</p>
                <p class="text-xs">Perpustakaan Umum Kota Solok</p>
            </div>
        </div>

        {{-- Desktop --}}
        <nav class="hidden xl:flex gap-6 text-sm items-center content-between" x-data="{ openDropDown: false, active: '{{ request()->route()->getName() }}' }">
            @php
                $menu = [
                    ['label' => 'Beranda', 'name' => 'home', 'icon' => 'home'],
                    ['label' => 'Daftar Koleksi', 'name' => 'collection', 'icon' => 'book-open'],
                    ['label' => 'Profil', 'name' => 'profile', 'icon' => 'building'],
                    ['label' => 'Kegiatan', 'name' => 'event', 'icon' => 'calendar'],
                    ['label' => 'Informasi', 'name' => 'information', 'icon' => 'info'],
                ];
            @endphp

            @php
                $options = [
                    ['status' => 'Akan Datang', 'value' => 'upcoming'],
                    ['status' => 'Sedang Berlangsung', 'value' => 'ongoing'],
                    ['status' => 'Sudah Selesai', 'value' => 'completed'],
                    ['status' => 'Dibatalkan', 'value' => 'cancelled'],
                ];

                $statusLabels = collect($options)->pluck('status', 'value');
            @endphp

            @foreach ($menu as $item)
                <div @mouseenter="openDropDown = '{{ $item['name'] }}'" @mouseleave="openDropDown = false" x-transition
                    x-cloack class="relative">
                    <a href="{{ route($item['name']) }}" @click="active = '{{ $item['name'] }}'"
                        class="flex items-center gap-2 py-2 hover:text-yellow-500 hover:border-b-yellow-500 hover:border-b transition-all text-xs"
                        :class="active === '{{ $item['name'] }}' ? 'border-b border-b-gray-50' : ''">
                        <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>

                    @if ($item['name'] === 'information')
                        <div class="absolute top-full left-0 mt-2 bg-neutral-50 text-neutral-700 shadow-lg w-48 z-50 border border-neutral-500 rounded-md text-sm"
                            x-show="openDropDown === 'information'" x-transition x-cloack>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-yellow-500 hover:text-neutral-50">Informasi
                                Perpustakaan</a>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-yellow-500 hover:text-neutral-50">Informasi Layanan</a>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-yellow-500 hover:text-neutral-50">Informasi
                                Kegiatan</a>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-yellow-500 hover:text-neutral-50">Informasi
                                Lowongan</a>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-yellow-500 hover:text-neutral-50">Informasi Sumber
                                Daya</a>
                        </div>
                    @endif

                    @if ($item['name'] === 'event')
                        <div class="absolute top-full left-0 mt-2 bg-neutral-50 text-neutral-700 shadow-lg w-48 z-50 border border-neutral-500 rounded-md text-sm"
                            x-show="openDropDown === 'event'" x-transition x-cloak>

                            @foreach ($statusLabels as $status => $events)
                                <a href="{{ route('event') }}"
                                    class="block px-4 py-2 hover:bg-yellow-500 hover:text-white">
                                    {{ $statusLabels[$status] }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    @if ($item['name'] === 'collection')
                        <div class="absolute top-full left-0 mt-2 bg-neutral-50 text-neutral-700 shadow-lg w-48 z-50 border border-neutral-500 rounded-md text-sm"
                            x-show="openDropDown === 'collection'" x-transition x-cloak>

                            @foreach ($categories as $category)
                                <a href="{{ route('collection') }}"
                                    class="block px-4 py-2 hover:bg-yellow-500 hover:text-white">
                                    {{ $category->name }}
                                </a>
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
        @php
            $menu = [
                ['label' => 'Beranda', 'name' => 'home', 'icon' => 'home'],
                ['label' => 'Daftar Koleksi', 'name' => 'collection', 'icon' => 'book-open'],
                ['label' => 'Profil', 'name' => 'profile', 'icon' => 'building'],

                // ['label' => 'Peminjaman', 'name' => 'borrows.index', 'icon' => 'list'],
                // ['label' => 'Pengguna', 'name' => 'users.index', 'icon' => 'user'],
            ];
        @endphp

        <div x-show="openNav" x-transition class="border-t border-neutral-600">
            @foreach ($menu as $item)
                <div class="">
                    <a href="{{ route($item['name']) }}" @click="active = '{{ $item['name'] }}'"
                        class="flex items-center gap-2 py-3 hover:text-neutral-50 px-3 hover:bg-amber-500 transition-all text-xs"
                        :class="active === '{{ $item['name'] }}' ? 'text-amber-500' : ''">

                        <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                </div>
            @endforeach
            <div class="p-3 pb-5 profile flex lg:hidden gap-3 items-center border-t border-neutral-600">
                <div class="">
                    <div class="name">
                        <div class="login flex gap-3">
                            <div class="bg-red-500 px-4 py-1 rounded">
                                <a href="/login">Login</a>
                            </div>
                        </div>
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
