<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title', 'Akses Utama | Perpustakaan Umum Kota Solok')
    </title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
</head>

<body>

    <div class="flex justify-between">
        {{-- Navbar --}}
        <nav class="">
            @include('master.layouts.navbar')
        </nav>

        {{-- Main --}}
        <main class="w-full">
            @yield('content')
        </main>
    </div>

</body>

</html>
