<div class="sticky top-0 left-0 flex flex-col bg-sky-950 w-80 h-screen" x-data="{ active: '{{ Route::currentRouteName() }}', transaction: false }">

    <!-- Logo -->
    <div class="flex items-center space-x-3 p-4">
        <i data-lucide="library" class="w-8 h-8 text-neutral-200"></i>

        <div class="logo leading-tight">
            <p class="font-extrabold font-serif text-neutral-200 text-lg">SOLIBRA</p>
            <p class="text-xs text-neutral-400">Perpustakaan Umum Kota Solok</p>
        </div>
    </div>

    <!-- User Info -->
    <div class="flex items-center space-x-3 p-4">
        <div class="logo leading-tight">
            <p class="text-neutral-50 text-xs font-bold">Admin: {{ Auth::user()->id }}</p>
            <p class="text-xs text-neutral-300">{{ Auth::user()->name }}</p>
        </div>
    </div>

    @php
        $menu = [
            ['label' => 'Beranda', 'name' => 'dashboard.index', 'icon' => 'home'],
            ['label' => 'Buku', 'name' => 'books.index', 'icon' => 'book-open'],
            ['label' => 'Kategori', 'name' => 'categories.index', 'icon' => 'layers'],
            [
                'label' => 'Transaksi',
                'icon' => 'list',
                'item' => [
                    ['label' => 'Peminjaman', 'name' => 'borrows.index', 'icon' => 'list'],
                    ['label' => 'Pengembalian', 'name' => 'return.index', 'icon' => 'repeat'],
                    ['label' => 'Arsip', 'name' => 'borrows.archived', 'icon' => 'archive'],
                ],
            ],
            ['label' => 'Pengguna', 'name' => 'users.index', 'icon' => 'user'],
            ['label' => 'Informasi', 'name' => 'informations.index', 'icon' => 'circle'],
            ['label' => 'Acara', 'name' => 'events.index', 'icon' => 'calendar-days'],
            ['label' => 'Notifikasi', 'name' => 'notifications.index', 'icon' => 'bell'],
            ['label' => 'Galeri', 'name' => 'galleries.index', 'icon' => 'gallery-vertical-end'],
        ];
    @endphp

    <!-- Menu -->
    <nav class="flex flex-col">
        @foreach ($menu as $item)
            @if (isset($item['item']))
                <!-- Parent (Transaksi) -->
                <button type="button" @click="transaction = !transaction"
                    class="flex items-center justify-between px-4 py-2 text-xs hover:bg-neutral-400 hover:text-sky-950 transition-all"
                    :class="transaction ? 'bg-neutral-400 text-sky-950' : 'text-neutral-200'">
                    <div class="flex items-center gap-2">
                        <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4"></i>
                        <span>{{ $item['label'] }}</span>
                    </div>
                    <svg :class="transaction ? 'rotate-90' : ''" class="w-3 h-3 transform transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Submenu -->
                <div x-show="transaction" x-transition class="flex flex-col pl-8">
                    @foreach ($item['item'] as $i)
                        <a href="{{ route($i['name']) }}" @click="active = '{{ $i['name'] }}'"
                            class="flex items-center gap-2 px-4 py-2 text-xs hover:bg-neutral-400 hover:text-sky-950 transition-all"
                            :class="active === '{{ $i['name'] }}' ? 'bg-neutral-400 text-sky-950' : 'text-neutral-200'">
                            <i data-lucide="{{ $i['icon'] }}" class="w-4 h-4"></i>
                            <span>{{ $i['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            @else
                <!-- Menu Biasa -->
                <a href="{{ route($item['name']) }}" @click="active = '{{ $item['name'] }}'"
                    class="flex items-center gap-2 px-4 py-2 text-xs hover:bg-neutral-400 hover:text-sky-950 transition-all"
                    :class="active === '{{ $item['name'] }}' ? 'bg-neutral-400 text-sky-950' : 'text-neutral-200'">
                    <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>
</div>
