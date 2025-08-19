@extends('member.layouts.app')

@section('title', 'Notifikasi')

@section('content')
    <div class="max-w-7xl mx-auto px-4 pt-10">
        <h1 class="text-2xl font-extrabold text-sky-800 mb-6">
            Notifikasi
        </h1>

        @if ($notifications->isEmpty())
            <p class="text-gray-500">Tidak ada notifikasi</p>
        @else
            <ul class="space-y-2">
                @foreach ($notifications as $notification)
                    <li class="p-3 bg-white rounded shadow-sm flex justify-between items-center">
                        <span>{{ $notification->message }}</span>
                        <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
