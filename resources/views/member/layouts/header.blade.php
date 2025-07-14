<div class="flex flex-row px-5 py-7 items-center justify-between sticky top-0 z-50 bg-teal-600 text-slate-50 shadow-md shadow-slate-500"
    x-data="{ active: '{{ Route::currentRouteName() }}' }">
    <div class="logo flex gap-2 items-center">
        <div class="w-8 h-8 bg-red-400">
            <i data-lucide="library" class="w-auto"></i>
        </div>
        <div class="">
            <p class="font-serif">SOLIBRA</p>
            <p class="text-xs">Perpustakaan Umum Kota Solok</p>
        </div>
    </div>

    <nav class="flex gap-6 text-sm items-center content-between">

        @php
            $menu = [
                ['label' => 'Beranda', 'name' => 'member.index', 'icon' => 'home'],
                ['label' => 'Daftar Koleksi', 'name' => 'member.collection', 'icon' => 'book-open'],
                ['label' => 'Sejarah', 'name' => 'member.history', 'icon' => 'layers'],

                // ['label' => 'Peminjaman', 'name' => 'borrows.index', 'icon' => 'list'],
                // ['label' => 'Pengguna', 'name' => 'users.index', 'icon' => 'user'],
            ];
        @endphp

        @foreach ($menu as $item)
            <div>
                <a href="{{ route($item['name']) }}" @click="active = '{{ $item['name'] }}'"
                    class="flex items-center gap-2 py-2 hover:text-slate-900 transition-all text-xs"
                    :class="active === '{{ $item['name'] }}' ? 'border-b border-b-gray-50' : ''">

                    <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            </div>
        @endforeach


    </nav>

    <div class="profile flex gap-3 items-center">
        <div class="">
            <div class="name">
                <p class="text-sm">{{ $user->name }}</p>
            </div>
        </div>
        <div class="profile-picture">
            <div class="w-10 h-10 bg-black rounded-full block" src="#" alt=""></div>
        </div>
    </div>
</div>
