<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Solibra - Perpustakaan Umum Kota Solok</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
</head>

<body class="bg-slate-200">

    <div x-data="{ show: {{ session('success') ? 'true' : 'false' }} }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="fixed inset-0 flex items-center justify-center z-50" x-transition x-cloak>
        <div class="bg-white shadow-xl rounded-xl p-6 border border-gray-200 max-w-md text-center">
            <p class="text-gray-700">{{ session('success') }}</p>
            <button @click="show = false"
                class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Tutup</button>
        </div>
    </div>


    <div class="flex flex-col">
        @include('admin.layouts.middle')
    </div>

    {{-- JS --}}
    <script src="{{ asset('js/admin/dashboard.js') }}"></script>
    <script src="{{ asset('js/admin/book.js') }}"></script>
    <script src="{{ asset('js/admin/borrow.js') }}"></script>
</body>

</html>
