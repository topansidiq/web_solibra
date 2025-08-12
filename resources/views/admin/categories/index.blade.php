@extends('admin.layouts.app')

@section('content')
    <div class="content flex flex-col flex-auto bg-gray-50 w-full">

        <div>
            <div x-data="{ show: {{ session('error') ? 'true' : 'false' }} }" x-show="show"
                x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition x-cloak>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold bg-red-300 px-2 py-1 rounded-sm">Gagal</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
            <div x-data="{ show: {{ session('success') ? 'true' : 'false' }} }" x-show="show"
                x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition x-cloak>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold bg-green-300 px-2 py-1 rounded-sm">Berhasil</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        </div>

        <div class="grid gap-4 p-4 items-center justify-between w-full">
            <div class="flex flex-row gap-2">
                {{-- Go to Dashboard --}}
                <div class="flex items-center w-fit">
                    <a href="{{ route('dashboard.index') }}" class="text-teal-950 font-bold">
                        <i data-lucide="layers" class="w-8 h-8 inline"></i>
                        <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                    </a>
                </div>

                <div class="">
                    <h3 class="text-xl text-neutral-700 font-bold">Daftar Kategori</h3>
                    <p class="text-xs text-neutral-500">Menu ini menampilkan daftar kategori buku yang tersedia di perpustakaan
                    </p>
                </div>
            </div>

            <div x-data="{ createCategory: false }">
                <button @click="createCategory=true" class="px-2 py-1 bg-sky-800 text-neutral-50 rounded-sm text-sm">Buat
                    Kategori
                    Baru</button>
                <div x-show="createCategory">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <input type="text"
                            class="w-lg px-2 py-1 rounded-md my-2 border border-neutral-400 focus:outline-none placeholder:text-xs text-sm"
                            placeholder="Masukkan kategori baru..." name="categories" id="categories">

                        <button type="submit"
                            class="px-4 py-2 bg-sky-800 rounded-sm text-xs text-neutral-50">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tabel Scrollable --}}
        <div class="mx-4">
            <table class="table font-sans w-full">
                <thead class="bg-sky-800 text-neutral-50 text-sm sticky top-0 z-10">
                    <tr>
                        <th class="p-4 text-center w-5">No.</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Total Buku</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ $category->id }}.
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-left">{{ $category->name }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center">{{ $category->created_at }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                @if ($category->books_count === 0)
                                    <span>Tidak ada</span>
                                @else
                                    {{ $category->books_count }}
                                @endif
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-center w-32">
                                <div class="flex items-center justify-center gap-1">
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus Kategori ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded flex items-center justify-center h-[25px]">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
