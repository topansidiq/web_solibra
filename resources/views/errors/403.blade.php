@extends('layouts.error')

@section('title', 'Akses Ditolak')

@section('content')
    <div class="mx-auto max-w-xl text-center py-16">
        <h1 class="text-6xl font-bold">403</h1>
        <p class="mt-4 text-lg">Maaf, kamu tidak memiliki akses ke halaman ini!</p>
        <a href="{{ url('/') }}" class="inline-block mt-6 px-4 py-2 bg-sky-700 text-neutral-50 rounded-md">
            Kembali ke Beranda
        </a>
    </div>
@endsection
