@extends('layouts.error')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
    <div class="mx-auto max-w-xl text-center py-16">
        <h1 class="text-6xl font-bold">404</h1>
        <p class="mt-4 text-lg">Maaf, halaman yang kamu cari tidak tersedia.</p>
        <a href="{{ url('/') }}" class="inline-block mt-6 px-4 py-2 rounded-md bg-sky-700 text-neutral-50">
            Kembali ke Beranda
        </a>
    </div>
@endsection
