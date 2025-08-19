@extends('layouts.app')

@section('title', 'Tampilan Buku')

@section('content')
    <div class="flex flex-col gap-4">
        <div class="max-w-6xl mx-auto bg-white rounded shadow-md">
            @if ($event)
                <div class="flex">
                    <img src="{{ asset('storage/' . $event->poster) }}" alt="" class="h-[480px]">
                    <div class="p-4">
                        <div>
                            <h1 class="text-xl font-bold">{{ $event->title }}</h1>
                            @if ($event->status == 'ongoing')
                                <p class="text-xs">{{ __('home.event_buttons.ongoing') }}</p>
                            @elseif ($event->status == 'upcoming')
                                <p class="text-xs">{{ __('home.event_buttons.upcoming') }}</p>
                            @elseif ($event->status == 'completed')
                                <p class="text-xs">{{ __('home.event_buttons.completed') }}</p>
                            @endif
                        </div>

                        <div class="detail grid gap-3 py-3">
                            <div class="grid grid-cols-4 text-sm">
                                <p class="col-span-1 font-semibold">{{ __('show_event.date') }}</p>
                                <p class="col-span-3">
                                    {{ \Carbon\Carbon::parse($event->start_at)->translatedFormat('j F Y') }}
                                    ({{ \Carbon\Carbon::parse($event->start_at)->diffForHumans() }})
                                    s/d
                                    {{ \Carbon\Carbon::parse($event->end_at)->translatedFormat('j F Y') }}
                                    ({{ \Carbon\Carbon::parse($event->end_at)->diffForHumans() }})
                                </p>
                            </div>
                            <div class="grid grid-cols-4 text-sm">
                                <p class="col-span-1 font-semibold">{{ __('show_event.location') }}</p>
                                <p class="col-span-3">{{ $event->location }}</p>
                            </div>
                            <div class="grid grid-cols-4 text-sm">
                                <p class="col-span-1 font-semibold">Link</p>
                                <p class="col-span-3 font-semibold">
                                    <a class="bg-neutral-200 px-2 py-1 rounded-sm underline text-sky-500"
                                        href="http://localhost:8000/show/event/1">http://localhost:8000/show/event/1</a>
                                </p>
                            </div>
                            <div class="grid grid-cols-4 text-sm">
                                <div class="col-span-4">
                                    {{ $event->description }}
                                </div>
                            </div>
                            <div>
                                <a href="{{ $event->link }}" target="_blank" class="text-blue-600 underline">
                                    {{ $event->link }}
                                </a>

                                <a href="#" class="px-2 py-1 bg-sky-500 text-white rounded-sm shadow-md">
                                    {{ __('show_event.register') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div>
                    <p>Tidak ada kegiatan</p>
                </div>
            @endif
        </div>
    </div>

@endsection
