@extends('admin.layouts.app')

@section('content')

<div class="content flex flex-col flex-auto bg-gray-50 w-full p-4">

    <div class="">
        <h3 class="text-xl text-neutral-700 font-bold">Detail Informasi</h3>
        <p class="text-xs text-neutral-500">{{ $information->title }}</p>
    </div>

    <div class="w-fit p-6 md:px-20 lg:px-40 bg-white m-6 rounded shadow-md space-y-6">

        <!-- Gambar -->
        @if ($information->images)
            <div>
                <img src="{{ asset('storage/' . $information->images) }}" alt="Gambar Informasi" class="rounded-md w-full max-h-[500px] object-cover">
            </div>
        @endif

        <!-- Judul -->
        <h1 class="text-4xl font-bold border-b pb-4">
            {{ $information->title }}
        </h1>

        <div class="flex flex-col sm:flex-row justify-between text-sm ">
            <span><strong>Penerbit:</strong> {{ $information->author }}</span>
            <span><strong>Tanggal:</strong> {{ $information->created_at->format('d M Y') }}</span>
        </div>
        <div class="prose max-w-full text-gray-700 text-base md:text-lg leading-relaxed">
            {!! $information->description !!}
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('informations.index') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold px-5 py-2 rounded-md">
                Kembali
            </a>
            {{-- <a href="{{ route('informations.update', $information->id) }}"
                class="inline-block bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold px-5 py-2 rounded-md">
                Edit
            </a> --}}
        </div>
    </div>
</div>
@endsection
