@extends('member.layouts.app')

@section('content')

<div class="bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-10 space-y-8 border border-gray-100">
            <!-- Judul -->
            <h1 class="text-3xl md:text-4xl font-extrabold text-sky-800 border-b pb-4">
                {{ $information->title }}
            </h1>

            <!-- Meta Info -->
            <div class="flex flex-row text-sm text-gray-500 space-x-6">
                <span><strong>Penerbit:</strong> {{ $information->author }}</span>
                <span><strong>Tanggal:</strong> {{ $information->created_at->locale(app()->getLocale())->translatedFormat('d F Y') }}</span>
            </div>

            <!-- Gambar -->
            @if ($information->images)
                <div class="overflow-hidden rounded-lg ">
                    <img
                        src="{{ asset('storage/' . $information->images) }}"
                        alt="Gambar Informasi"
                        class="w-full h-auto max-h-[500px] object-contain mx-auto"
                    >
                </div>
            @endif

            <!-- Deskripsi -->
            <div class="prose max-w-none text-gray-800 text-base md:text-lg leading-relaxed">
                {!! $information->description !!}
            </div>

            <!-- Tombol Kembali -->
            <div class="flex justify-end pt-4">
                <a href="{{ route('member.information')}}"
                   class="inline-block bg-sky-800 hover:bg-sky-900 text-white text-sm font-medium px-6 py-2 rounded-md transition">
                    ← Kembali ke Informasi
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
