@extends('admin.layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-6 p-4 bg-white rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Notifikasi Anda</h2>

        @if ($notifications->isEmpty())
            <p class="text-gray-500">Tidak ada notifikasi.</p>
        @else
            <ul class="space-y-3">
                @foreach ($notifications as $notification)
                    <li
                        class="p-3 border rounded {{ $notification->is_read ? 'bg-gray-100 text-gray-600' : 'bg-yellow-50 text-black font-semibold' }}">
                        <div class="flex justify-between items-center">
                            <div>{{ $notification->message }}</div>
                            @unless ($notification->is_read)
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:underline text-sm">Tandai dibaca</button>
                                </form>
                            @endunless
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
