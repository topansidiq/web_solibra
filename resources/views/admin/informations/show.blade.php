@extends('admin.layouts.app')

@section('content')
    <div class="w-full">
        <div class="flex flex-row gap-2 p-4">
            <div class="flex items-center w-fit">
                <a href="{{ route('informations.index') }}" class="text-neutral-700 flex items-center">
                    <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                </a>
            </div>
            <div>
                <h3 class="text-xl text-neutral-700 font-bold">Detail Informasi</h3>
                <p class="text-xs text-neutral-500">Detail lengkap dari informasi terpilih</p>
            </div>
        </div>

        <div class="mx-4 mb-4 p-4 rounded-sm bg-neutral-50 grid grid-cols-2 gap-5">
            <div class="col-span-2">
                @if ($information->images)
                    <div class="overflow-hidden rounded-lg">
                        <img src="{{ asset('storage/' . $information->images) }}" alt="Gambar Informasi"
                            class="w-full h-auto max-h-[350px] object-contain mx-auto">
                    </div>
                @endif
                <h1 class="text-4xl font-bold border-b pb-4">
                    {{ $information->title }}
                </h1>
                <div class="flex flex-col sm:flex-row justify-between text-sm gap-2 sm:gap-0 py-2">
                    <span><strong>Penerbit:</strong> {{ $information->author }}</span>
                    <span><strong>Tanggal:</strong> {{ $information->created_at->locale('id')->translatedFormat('d F Y') }}</span>
                </div>
                <div class="prose max-w-full text-gray-700 text-base md:text-lg leading-relaxed">
                    {!! $information->description !!}
                </div>

                <div class="col-span-2 flex justify-end">
                    <a href="{{ route('informations.index') }}"
                        class="text-xs bg-sky-800 text-white px-6 py-2 rounded hover:bg-sky-900 transition">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
