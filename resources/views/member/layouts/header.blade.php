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
                    ['label' => 'Beranda', 'name' => 'member.index', 'icon' => 'home'],
                    ['label' => 'Daftar Koleksi', 'name' => 'member.collection', 'icon' => 'book-open'],
                    ['label' => 'Profile', 'name' => 'member.profile', 'icon' => 'building'],

                    // ['label' => 'Peminjaman', 'name' => 'borrows.index', 'icon' => 'list'],
                    // ['label' => 'Pengguna', 'name' => 'users.index', 'icon' => 'user'],
                ];
            @endphp

            @foreach ($menu as $item)
                @if ($item['name'] == 'member.profile')
                    <div>
                        <a href="{{ route($item['name']) }}" @click="active = '{{ $item['name'] }}'"
                            class="flex items-center gap-2 py-2 hover:text-yellow-500 hover:border-b-yellow-500 hover:border-b transition-all text-xs"
                            :class="active === '{{ $item['name'] }}' ? 'border-b border-b-gray-50' : ''">

                            <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    </div>
                    @continue
                @endif
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
            <div class="">
                <div class="name">
                    <p class="text-sm">{{ $user->name }}</p>
                </div>
            </div>
            <div class="profile-picture">
                <div class="w-10 h-10 bg-yellow-500 rounded-full block" src="#" alt=""></div>
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
                ['label' => 'Beranda', 'name' => 'member.index', 'icon' => 'home'],
                ['label' => 'Daftar Koleksi', 'name' => 'member.collection', 'icon' => 'book-open'],
                ['label' => 'Sejarah', 'name' => 'member.history', 'icon' => 'layers'],

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
                        <div class="flex gap-3 items-center pt-2">
                            <div class="profile-picture">
                                <div class="w-7 h-7 bg-amber-500 rounded-full block" src="#" alt="">
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-neutral-400">Anggota: {{ $user->id }}</p>
                                <p class="text-sm">{{ $user->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </nav>
</div>
