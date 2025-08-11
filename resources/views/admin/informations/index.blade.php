@extends('admin.layouts.app')

@section('content')
    <div class="content flex flex-col flex-auto bg-gray-50 w-full" x-data="{ openAddinformationModal: false }" x-cloak>
        <div x-data="{ show: {{ session('error') ? 'true' : 'false' }} }" x-show="show"
            x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition x-cloak>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold bg-red-300 px-2 py-1 rounded-sm">Gagal</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
        <div x-data="{ show: {{ session('success') ? 'true' : 'false' }} }" x-show="show"
            x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition x-cloak>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold bg-green-300 px-2 py-1 rounded-sm">Berhasil</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
        <div class="title p-4 flex items-center justify-between">
            {{-- Header/Page Title/Page Description --}}
            <div class="flex flex-row gap-2">
                {{-- Go to Dashboard --}}
                <div class="flex items-center w-fit">
                    <a href="{{ route('dashboard.index') }}" class="text-teal-950 font-bold">
                        <i data-lucide="circle" class="w-8 h-8 inline"></i>
                        <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                    </a>
                </div>

                <div class="">
                    <h3 class="text-xl text-neutral-700 font-bold">Daftar Informasi</h3>
                    <p class="text-xs text-neutral-500">Menu ini menampilkan daftar informasi atau postingan di perpustakaan
                    </p>
                </div>
            </div>
            <div>
                <a href="{{ route('informations.create') }}"
                    class="flex flex-row items-center justify-around cursor-pointer rounded-md px-2 py-1 bg-sky-800 text-slate-200">
                    <i data-lucide="plus" class="block w-5 h-5"></i>
                    <p class="text-sm">Tambah Informasi</p>
                </a>
            </div>
        </div>

        {{-- Tabel Scrollable --}}
        <div class="mx-4">
            <table class="table font-sans w-full">
                <thead class="bg-sky-800 text-white text-sm sticky top-0 z-10">
                    <tr>
                        <th class="p-4 text-center">No.</th>
                        <th class="p-4">Judul</th>
                        <th class="p-4">Penulis</th>
                        <th class="p-4">Tanggal Buat</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                    @php
                        $number = 1;
                    @endphp
                    @foreach ($informations as $information)
                        <tr>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ $number++ }}
                            </td>
                            <td class="px-4 py-1 border border-slate-300">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('informations.show', $information->id) }}">
                                        <p class="outline-0">
                                            {{ $information->title }}
                                        </p>
                                    </a>
                                </div>
                            </td>
                            <td class="px-4 py-1 border border-slate-300">
                                {{ $information->author}}
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ \Carbon\Carbon::parse($information->created_at)->format('d-m-Y') }}
                            </td>

                            <td class="px-4 py-1 border border-slate-300 text-center w-32">
                                <div class="flex items-center justify-center gap-1">
                                    {{-- Tombol Detail --}}
                                    <a href="{{ route('informations.show', $information->id) }}"
                                        class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1 rounded">
                                        Detail
                                    </a>

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('informations.edit', $information->id) }}"
                                        class="bg-sky-800 hover:bg-sky-900 text-white text-xs px-3 py-1 rounded">
                                        Edit
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('informations.destroy', $information) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus informasi ini?')" class="inline-block">
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

            {{ $informations->links() }}
        </div>
    </div>
@endsection
