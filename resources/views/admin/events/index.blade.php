@extends('admin.layouts.app')

@section('content')
    <div class="content flex flex-col flex-auto bg-gray-50 w-full" x-data="{ openAddBookModal: false }">
        <div class="title p-4 flex flex-row items-center justify-between">

            {{-- Header/Page Title/Page Description --}}
            <div class="flex flex-row gap-2">
                {{-- Go to Dashboard --}}
                <div class="flex items-center w-fit">
                    <a href="{{ route('dashboard.index') }}" class="text-teal-950 font-bold">
                        <i data-lucide="home" class="w-8 h-8 inline"></i>
                        <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                    </a>
                </div>

                <div>
                    <h3 class="text-xl font-bold">Daftar Acara</h3>
                    <p class="text-sm">Ini adalah daftar acara di Perpustakaan Umum kota Solok</p>
                </div>
            </div>

            {{-- Action --}}
            <div>
                <a href="{{ route('events.create') }}"
                    class="flex flex-row items-center justify-around cursor-pointer rounded-md px-2 py-1 bg-sky-800 text-slate-200">
                    <i data-lucide="plus" class="block w-5 h-5"></i>
                    <p class="text-sm">Tambah Acara</p>
                </a>
            </div>
        </div>

        {{-- Tabel Scrollable --}}
        <div class="mx-4">
            <table class="table font-sans w-full">
                <thead class="bg-sky-800 text-white text-sm sticky top-0 z-10">
                    <tr>
                        <th class="p-4">No.</th>
                        <th class="p-4">Judul Kegiatan</th>
                        <th class="p-4">Tanggal Mulai</th>
                        <th class="p-4">Tanggal Selesai</th>
                        <th class="p-4">Lokasi</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                    @foreach ($events as $event)
                        <tr>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ $loop->iteration + ($events->currentPage() - 1) * $events->perPage() }}
                            </td>

                            <td class="px-4 py-1 border border-slate-300">
                                <div class="flex flex-row gap-2 justify-between items-center">
                                    <p class="text-left">{{ $event->title }}</p>
                                </div>
                            </td>

                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ \Carbon\Carbon::parse($event->start_at)->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-center">
                                {{ \Carbon\Carbon::parse($event->end_at)->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-1 border border-slate-300 text-center">{{ $event->location }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center">{{ $event->status }}</td>
                            <td class="px-4 py-1 border border-slate-300 text-center w-32">
                                <div class="flex items-center justify-center gap-1">
                                    {{-- <a href="{{ route('events.show', $event->id) }}"
                                        class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1 rounded">
                                        Detail
                                    </a> --}}
                                    {{-- <a href="{{ route('events.edit', $event->id) }}"
                                        class="bg-sky-800 hover:bg-sky-900 text-white text-xs px-3 py-1 rounded">
                                        Edit
                                    </a> --}}
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus acara ini?')"
                                        class="inline-block">
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
