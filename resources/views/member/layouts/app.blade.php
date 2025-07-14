<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SOLIBRA - Perpustakaan Umum Kota Solok</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="scrollbar-custom  overflow-y-scroll hide-scrollbar">
    @include('member.layouts.header')
    @yield('content')
    <x-footer-guest />
</body>

</html>
