@extends('master.layouts.app')

@section('content')
    {{-- Session flash --}}
    <section class="session">
        <div x-data="{ show: {{ session('error') ? 'true' : 'false' }} }" x-show="show" x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition
            x-cloak>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold bg-red-300 px-2 py-1 rounded-sm">Gagal</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
        <div x-data="{ show: {{ session('success') ? 'true' : 'false' }} }" x-show="show" x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition
            x-cloak>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold bg-green-300 px-2 py-1 rounded-sm">Berhasil</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    </section>

    {{-- Content --}}
    <section class="content">
        {{-- Header/page title --}}
        <div class="header">
            <h1 class="text-xl font-bold text-neutral-700 border-b border-slate-300 p-4">Beranda</h1>
        </div>

        {{-- Main/content --}}
        <div class="p-4">
            <div class="grid grid-cols-4 gap-3">
                {{-- Card --}}
                <div class="rounded-md shadow border border-slate-200 p-3 text-center">
                    <h2 class="text-sm">Total Admin</h2>
                    <p class="text-3xl font-bold text-neutral-700">
                        {{ $admins->count() }}
                    </p>
                </div>
                <div class="rounded-md shadow border border-slate-200 p-3 text-center">
                    <h2 class="text-sm">Total Anggota</h2>
                    <p class="text-3xl font-bold text-neutral-700">
                        {{ $members->count() }}
                    </p>
                </div>
                <div class="rounded-md shadow border border-slate-200 p-3 text-center">
                    <h2 class="text-sm">Total Koleksi</h2>
                    <p class="text-3xl font-bold text-neutral-700">
                        {{ $members->count() }}
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
