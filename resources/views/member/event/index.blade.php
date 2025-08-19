@extends('member.layouts.app')

@section('title', __('main.navigation.event') . " | Perpustakaan Umum Kota Solok")

@php
    $options = [
        ['status' => 'Akan Datang', 'value' => 'upcoming'],
        ['status' => 'Sedang Berlangsung', 'value' => 'ongoing'],
        ['status' => 'Sudah Selesai', 'value' => 'completed'],
        ['status' => 'Dibatalkan', 'value' => 'cancelled'],
    ];

    $statusLabels = collect($options)->pluck('status', 'value');
@endphp

@section('content')
    <div>
        <div class="mx-auto">
            <div class="flex bg-gray-50 gap-4 p-4 mx-auto items-center justify-between">
                <div>
                    <p class="font-bold text-lg text-slate-800">Kegiatan Terbaru</p>
                    <p class="text-xs text-neutral-500">Ikuti beragam kegiatan menarik kami!</p>
                </div>

                {{-- Filter Event --}}
                <div class="block gap-6 text-sm items-center content-between" x-data="{ openNav: false }">
                    <div @mouseenter="openNav=true" @mouseleave="openNav=false"
                        class="w-40 cursor-pointer bg-sky-50 border border-sky-200 rounded-md">
                        <span class="p-2 block text-center">Filter Kegiatan</span>
                        <div x-show="openNav" x-transition class="border-t border-neutral-600 bg-sky-50 fixed w-40">
                            @foreach ($options as $option)
                                <div class="">
                                    <a href="#"
                                        class="flex items-center gap-2 py-3 hover:text-neutral-50 px-3 hover:bg-sky-500 transition-all text-xs"
                                        :class="active === '{{ $option['value'] }}' ? 'text-sky-500' : ''">
                                        <span>{{ $option['status'] }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-auto">
            <div class="p-4 mx-auto">
                @foreach ($events as $status => $eventGroup)
                    {{-- Header berdasarkan mapping --}}
                    <div class="flex items-center justify-center mb-4">
                        <div class="border-t border-gray-300 flex-grow"></div>
                        <span id="{{ Str::slug($statusLabels[$status]) }}"
                            class="mx-4 text-gray-500 text-sm">{{ $statusLabels[$status] ?? ucfirst($status) }}</span>
                        <div class="border-t border-gray-300 flex-grow"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($eventGroup as $event)
                            <div
                                class="event h-full bg-slate-50 rounded shadow border border-slate-300 cursor-pointer hover:scale-105 transition duration-200">
                                <div class="h-48 overflow-hidden rounded-t">
                                    <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="p-3">
                                    <h2 class="font-bold text-sm text-neutral-700 mb-1">{{ $event->title }}</h2>
                                    <p class="text-xs text-gray-500 mb-1">
                                        {{ \Carbon\Carbon::parse($event->start_at)->format('d M Y H:i') }} -
                                        {{ \Carbon\Carbon::parse($event->end_at)->format('H:i') }}
                                    </p>
                                    <p class="text-xs text-gray-600 mb-1">📍 {{ $event->location }}</p>
                                    <p class="text-xs text-gray-700">{!! Str::limit(strip_tags($event->description), 35, '...') !!}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
