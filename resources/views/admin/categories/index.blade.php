@extends('admin.layouts.app')

@section('content')
    <div class="content flex flex-col flex-auto bg-gray-50 w-full">
        <div class="title p-4 flex items-center justify-between">
            {{-- Header/Page Title/Page Description --}}
            <div class="flex flex-row gap-2">
                {{-- Go to Dashboard --}}
                <div class="flex items-center w-fit">
                    <a href="{{ route('dashboard.index') }}" class="text-teal-950 font-bold">
                        <i data-lucide="layers" class="w-8 h-8 inline"></i>
                        <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                    </a>
                </div>

                <div class="">
                    <h3 class="text-xl text-neutral-700 font-bold">Daftar Kategori Buku</h3>
                    <p class="text-xs text-neutral-500">Menu ini menampilkan daftar kategori buku di perpustakaan
                    </p>
                </div>
            </div>
            <div x-data="{ open: false }">
                <div @click="open = true"
                    class="flex flex-row items-center justify-around cursor-pointer rounded-md px-2 py-1 bg-sky-800 text-slate-200">
                    <i data-lucide="plus" class="block w-5 h-5"></i>
                    <p class="text-sm">Tambah Kategori</p>
                </div>

                <div x-cloak x-transition class="modal-add bg-white shadow-2xl rounded-lg fixed top-32 left-52 w-fit"
                    x-show="open">
                    <div class="bg-sky-800 w-full p-4 rounded-t-lg cursor-move modal-add-header">
                        <h2 class="text-xl font-bold flex align-middle justify-between">
                            <span class="block text-white">Tambah Kategori Baru</span>
                            <button @click="open=false"><i class="block w-6 h-6 text-white text-sm cursor-pointer"
                                    data-lucide="x"></i></button>
                        </h2>
                    </div>

                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
                        class="grid grid-cols-2 gap-4 p-5 w-full">
                        @csrf

                        <div>
                            <label for="name" class="block font-semibold">Kategori</label>
                            <input type="text" name="name" id="name"
                                class="form-input w-96 border-b border-slate-400 focus:outline-0 p-2 placeholder: text-sm"
                                placeholder="Contoh: Pemrograman Web" required>
                        </div>

                        <div class="col-span-2 pt-4 flex flex-row content-end gap-4 justify-end-safe">
                            <button @click="open = false"
                                class="block rounded-sm font-bold bg-red-500 px-3 py-1 w-28 text-white hover:scale-105 transition-all">Batal</button>
                            <button type="submit"
                                class="bg-sky-800 px-3 py-1 rounded-sm font-bold text-white block w-28 hover:scale-105 transition-all">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tabel Scrollable --}}
        <div class="mx-4">
            <table class="table font-sans w-full">
                <thead class="bg-sky-800 text-white text-sm sticky top-0 z-10">
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
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ \Carbon\Carbon::parse($category->created_at)->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-center">{{ $category->books_count }}
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
