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

                $home = __('member_header.home');
                $profile = __('member_header.profile');
                $collection = __('member_header.collection');
                $borrowing = __('member_header.borrowing');
                $information = __('member_header.information');
                $notification = __('member_header.notification');
                $account = __('member_header.account');

                $menu = [
                    ['label' => $home, 'name' => 'member.index'],
                    ['label' => $profile, 'name' => 'member.profile'],
                    ['label' => $collection, 'name' => 'member.collection'],
                    ['label' => $borrowing, 'name' => 'member.borrow'],
                    ['label' => $information, 'name' => 'member.information'],
                    ['label' => $notification, 'name' => 'member.notification'],
                    ['label' => $account, 'name' => 'member.account'],

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


                            <span>{{ $item['label'] }}</span>
                        </a>
                    </div>
                    @continue
                @endif
                <div>
                    <a href="{{ route($item['name']) }}" @click="active = '{{ $item['name'] }}'"
                        class="flex items-center gap-2 py-2 hover:text-yellow-500 hover:border-b-yellow-500 hover:border-b transition-all text-xs"
                        :class="active === '{{ $item['name'] }}' ? 'border-b border-b-gray-50' : ''">


                        <span>{{ $item['label'] }}</span>
                    </a>
                </div>
            @endforeach
        </nav>

        @php
            use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
        @endphp

        <div class="profile hidden lg:flex gap-3 items-center p-3">
            <div>
                <ul>
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li>
                            <a rel="alternate" hreflang="{{ $localeCode }}"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                {{ $properties['native'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
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
                ['label' => 'Profil', 'name' => 'profile', 'icon' => 'building'],
                ['label' => 'Daftar Koleksi', 'name' => 'member.collection', 'icon' => 'book-open'],
                ['label' => 'Peminjaman', 'name' => 'member.borrow', 'icon' => 'book'],
                ['label' => 'Peminjaman', 'name' => 'member.borrow', 'icon' => 'book'],


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
