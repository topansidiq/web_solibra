@extends('layouts.error')
@section('title', 'Server Bermasalah!')
@section('content')
    <div class="mx-auto max-w-xl text-center py-16">
        <h1 class="text-6xl font-bold">500</h1>
        <p class="mt-4 text-lg">Oops! Terjadi kesalahan pada server.</p>
        <p class="mt-2 text-gray-600">Silakan coba lagi nanti atau hubungi admin jika masalah berlanjut.</p>
        <a href="{{ url('/') }}" class="inline-block mt-6 px-4 py-2 bg-sky-700 text-neutral-50 rounded-md">
            Kembali ke Beranda
        </a>
    </div>
@endsection
