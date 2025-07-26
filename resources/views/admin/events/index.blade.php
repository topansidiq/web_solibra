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
                    <h3 class="text-xl font-bold">Daftar Koleksi</h3>
                    <p class="text-sm">Ini adalah daftar koleksi buku yang tersedia di perpustakaan</p>
                </div>
            </div>

            {{-- Action --}}
            <div class="flex gap-4">

            </div>
        </div>

        {{-- Tabel Scrollable --}}
        <div class="mx-4">
            <table class="table font-sans w-full">
                <thead class="bg-teal-800 text-white text-sm sticky top-0 z-10">
                    <tr>
                        <th class="p-4">No.</th>
                        <th class="p-4">Judul Kegiatan</th>
                        <th class="p-4">Tanggal Mulai</th>
                        <th class="p-4">Tanggal Selesai</th>
                        <th class="p-4">Lokasi</th>
                        <th class="p-4">Status</th>
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
                                    <form class="flex items-center gap-2">
                                        {{-- Edit Book Button --}}
                                        <a href="{{ route('events.edit', $event->id) }}" class="block">
                                            <i data-lucide="edit" class="w-4 h-4 text-blue-500"></i>
                                        </a>

                                        {{-- Book Title --}}
                                        <p class="text-left">{{ $event->title }}</p>
                                    </form>

                                    {{-- Delete Book Button --}}
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-book-btn">
                                            <i data-lucide="trash-2" class="w-4 h-4 text-red-500"></i>
                                        </button>
                                    </form>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
