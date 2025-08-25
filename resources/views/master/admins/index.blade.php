@extends('master.layouts.app')

@section('title', 'Daftar Admin | Perpustakaan Umum Kota Solok')

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
            <h1 class="text-xl font-bold text-neutral-700 border-b border-slate-300 p-4">Daftar Admin</h1>
        </div>

        {{-- Main/content --}}
        @if ($admins->count() <= 0)
            <div class="p-4">
                <p class="font-light text-sm text-red-500">Admin tidak tersedia (kosong)</p>
            </div>
        @else
            <div class="p-4">
                <table>
                    <thead class="bg-sky-950 text-neutral-50">
                        <tr>
                            <th class="px-3 py-2">ID</th>
                            <th class="px-3 py-2">Name</th>
                            <th class="px-3 py-2">Email</th>
                            <th class="px-3 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-neutral-700">
                        @foreach ($admins as $admin)
                            <tr>
                                <td class="text-center px-2 py-1 border border-neutral-300">{{ $admin->id }}</td>
                                <td class="px-2 py-1 border border-neutral-300">{{ $admin->name }}</td>
                                <td class="px-2 py-1 border border-neutral-300">{{ $admin->email }}</td>
                                <td class="px-2 py-1 border border-neutral-300 flex gap-2">
                                    <div class=" text-green-500 px-2 py-1">
                                        <a href="#" class="block">
                                            <i class="w-5 h-5" data-lucide="edit"></i>
                                        </a>
                                    </div>
                                    <div class=" text-red-500 px-2 py-1">
                                        <a href="#" class="block">
                                            <i class="w-5 h-5" data-lucide="delete"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
