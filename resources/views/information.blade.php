@extends('layouts.app')

@section('title', 'Informasi | Perpustakaan Umum Kota Solok')

@section('content')
    <div>
        <div class="xl:w-[1680px] md:w-auto mx-auto">
            <div class="flex bg-gray-50 gap-4 p-4 mx-auto items-center justify-between">
                <div>
                    <p class="font-bold text-lg text-slate-800">Pojok Informasi</p>
                    <p class="text-xs text-neutral-500">Halaman ini memuat berbagai informasi seputar Perpustakaan Umum Kota
                        Solok</p>
                </div>
                {{-- Filter Event --}}
                <div class="block gap-6 text-sm items-center content-between" x-data="{ openNav: false }">
                    <div @mouseenter="openNav=true" @mouseleave="openNav=false"
                        class="w-40 cursor-pointer bg-sky-50 border border-sky-200 rounded-md">
                        <span class="p-2 block text-center">Filter Kegiatan</span>
                        <div x-show="openNav" x-transition class="border-t border-neutral-600 bg-sky-50 fixed w-40">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="xl:w-[1680px] md:w-auto mx-auto">
            <div class="gap-4 p-4 mx-auto content-around">

            </div>
        </div>
    </div>
@endsection
