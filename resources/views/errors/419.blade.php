@extends('layouts.error')
@section('title', 'Sesi Sudah Kadaluarsa')
@section('content')
    <div class="mx-auto text-center py-16">
        <h1 class="text-6xl font-bold">419</h1>
        <p class="mt-4 text-lg">Halaman Sudah Kadaluarsa</p>
        <p class="mt-2 text-gray-600">Sesi anda sudah habis atau token tidak valid. Silakan segarkan kembali halaman dan coba
            lagi.
        </p>
        <a href="{{ url('/login') }}" class="inline-block mt-6 px-4 py-2 bg-sky-700 text-neutral-50 rounded-md">
            Coba Lagi
        </a>
    </div>
@endsection
