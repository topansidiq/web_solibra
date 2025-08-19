@extends('layouts.app')

@section('title', 'Geleri | Perpustakaan Umum Kota Solok')

@section('content')
    <main class="max-w-7xl mx-auto mt-3">
        <div>
            <p class="font-bold text-lg text-slate-800">{{ __('gallery.title') }}</p>
            <p class="text-xs text-neutral-500">{{ __('gallery.subtitle') }}</p>
        </div>
        <div class="grid grid-cols-3 gap-3 py-4">
            @foreach ($galleries as $media)
                <div class="mx-auto border border-neutral-200 rounded-md max-h-[400px] w-full">
                    <div class="h-[300px] overflow-hidden">
                        <img src="{{ asset('storage/' . $media->file) }}" class="h-full w-full object-contain">
                    </div>
                    <div class="p-4 h-[100] text-sm">
                        {{ $media->description }}
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection
