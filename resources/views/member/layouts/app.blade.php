<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Perpustakaan Umum Kota Solok')</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-white">
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
            class="fixed top-5 bg-sky-500 text-white px-4 py-3 rounded shadow z-50">
            {{ session('success') }}
            <button @click="show = false" class="ml-2 font-bold">×</button>
        </div>
    @endif


    @include('member.layouts.header')
    @yield('content')
    @include('components.footer-guest')
</body>

</html>
