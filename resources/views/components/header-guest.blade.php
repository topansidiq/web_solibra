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
        <nav class="hidden xl:flex gap-6 text-sm items-center content-between">


            @php
                $menu = [
                    ['label' => 'Beranda', 'name' => 'home', 'icon' => 'home'],
                    ['label' => 'Daftar Koleksi', 'name' => 'collection', 'icon' => 'book-open'],
                    ['label' => 'Profil', 'name' => 'profile', 'icon' => 'building'],
                    ['label' => 'Kegiatan', 'name' => 'event', 'icon' => 'calendar'],

                    // ['label' => 'Peminjaman', 'name' => 'borrows.index', 'icon' => 'list'],
                    // ['label' => 'Pengguna', 'name' => 'users.index', 'icon' => 'user'],
                ];
            @endphp

            @foreach ($menu as $item)
                <div>
                    <a href="{{ route($item['name']) }}" @click="active = '{{ $item['name'] }}'"
                        class="flex items-center gap-2 py-2 hover:text-yellow-500 hover:border-b-yellow-500 hover:border-b transition-all text-xs"
                        :class="active === '{{ $item['name'] }}' ? 'border-b border-b-gray-50' : ''">

                        <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                </div>
            @endforeach
        </nav>

        <div class="profile hidden lg:flex gap-3 items-center p-3">
            <div class="text-sm">
                @foreach (LaravelLocalization::getSupportedLocales() as $code => $locale)
                    <a href="{{ LaravelLocalization::getLocalizedURL($code) }}"
                        class="px-1 {{ LaravelLocalization::getCurrentLocale() === $code ? 'font-bold text-sky-300' : 'text-neutral-200' }}">
                        {{ strtoupper($code) }}
                    </a>
                    @if (!$loop->last)
                        |
                    @endif
                @endforeach
            </div>

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

    </nav>
</div>
