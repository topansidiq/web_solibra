@extends('member.layouts.app')

@section('title', 'Notikasi')

@section('content')
    <div>
        <div class="text-xl">Halaman Notifikasi</div>
        @if ($notifications->isEmpty())
            <p>Tidak ada notifikasi</p>
        @else
            <ul>
            @foreach ($notifications as $notification)
                <li>{{ $notification->message }}</li>
            @endforeach
        </ul>
        @endif
    </div>
@endsection
