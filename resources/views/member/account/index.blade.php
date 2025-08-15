@extends('member.layouts.app')

@section('title', 'Accout | Perpustakaan Umum Kota Solok')

@section('content')
    <div class="bg-gray-50 text-gray-900 font-sans antialiased min-h-screen p-6">
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
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Left profile panel -->
            <section class="col-span-1 flex flex-col items-center md:items-start">
                <div class="relative rounded-full border-4 border-gray-300 w-48 h-48 overflow-hidden mb-4">

                    @if (empty($user->profile_picture))
                        @if ($user->gender == 'P')
                            <img src="{{ asset('img/female.png') }}" class="w-full h-full object-top" />
                        @elseif ($user->gender == 'L')
                            <img src="{{ asset('img/male.png') }}" class="w-full h-full object-cover" />
                        @else
                            <img src="{{ asset('img/male.png') }}" class="w-full h-full object-cover" />
                        @endif
                    @else
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" class="w-full h-full object-cover" />
                    @endif
                </div>

                <div class="text-center md:text-left">
                    <h1 class="text-xl font-semibold">{{ $user->name }}</h1>
                    <p class="text-gray-500 mb-2 text-sm">
                        <span class="font-bold">Status: </span>
                        <span class="cursor-pointer">
                            @if ($user->member_status == 'new')
                                <a href="{{ route('member.verification', $user->id) }}">
                                    Baru <button
                                        class="text-xs border bg-neutral-500 text-neutral-50 rounded-lg px-2 hover:bg-neutral-700">Belum
                                        Terverifikasi</button>
                                </a>
                            @elseif ($user->member_status == 'active')
                                <span
                                    class="text-xs border bg-sky-500 text-neutral-50 rounded-lg px-2 hover:bg-neutral-700">
                                    Terverifikasi
                                </span>
                            @endif
                        </span>
                    </p>
                    <button
                        class="w-full mx-auto md:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm rounded-md py-2 px-4 mb-6 transition">
                        Edit Profil
                    </button>

                    {{-- <ul class="space-y-3 text-sm text-gray-600 mb-6">
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 12.414m0 0L9.172 8.172m4.242 4.242l4.242 4.242m-8.484-8.484l4.242 4.242" />
                            </svg>
                            <span>2 followers • 2 following</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 11c0 4-3 7-3 7s-3-3-3-7a6 6 0 1112 0c0 4-3 7-3 7s-3-3-3-7z" />
                            </svg>
                            <span>Padang, Indonesia</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="2" y="5" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 3h-1a4 4 0 000 8h1a4 4 0 010 8h-1"></path>
                            </svg>
                            <a href="https://www.instagram.com/topanisme_" target="_blank" rel="noopener"
                                class="hover:text-blue-600">topanisme_</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="currentColor"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M19 0h-14c-2.209 0-4 1.791-4 4v16c0 1.105.895 2 2 2h4v-8h-2v-2h2v-1c0-2.206 1.794-4 4-4h3v2h-3c-.551 0-1 .449-1 1v1h4l-1 2h-3v8h5c1.105 0 2-.895 2-2v-16c0-2.209-1.791-4-4-4z">
                                </path>
                            </svg>
                            <a href="https://linkedin.com/in/topanisme" target="_blank" rel="noopener"
                                class="hover:text-blue-600">in/topanisme</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M14 2H6a2 2 0 00-2 2v16l4-4h6a2 2 0 002-2V4a2 2 0 00-2-2z" />
                            </svg>
                            <span>@topanisme_</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="currentColor"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12 2a10 10 0 00-3.16 19.42c.5.09.68-.22.68-.48v-1.7c-2.8.61-3.38-1.35-3.38-1.35-.45-1.14-1.1-1.44-1.1-1.44-.9-.62.07-.61.07-.61 1 .07 1.53 1.02 1.53 1.02.89 1.53 2.34 1.1 2.9.84.09-.66.35-1.1.63-1.36-2.24-.26-4.6-1.12-4.6-4.97 0-1.1.38-2 .99-2.7a3.4 3.4 0 01.09-2.67s.81-.26 2.64 1a9.26 9.26 0 014.8 0c1.83-1.26 2.63-1 2.63-1a3.4 3.4 0 01.09 2.7c.61.7 1 1.6 1 2.7 0 3.86-2.37 4.7-4.63 4.96.36.32.68.95.68 1.92v2.85c0 .26.18.57.69.47A10 10 0 0012 2z" />
                            </svg>
                            <a href="https://youtube.com/@topanisme" target="_blank" rel="noopener"
                                class="hover:text-blue-600">@topanisme</a>
                        </li>
                    </ul> --}}

                    <hr class="border-gray-300 w-full mb-6" />
                </div>
            </section>
        </div>
    </div>
@endsection
