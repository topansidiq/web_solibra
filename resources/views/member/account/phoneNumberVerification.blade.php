@extends('member.layouts.app')

@section('title', 'Verifikasi Nomor WhatsApp')

@section('content')
    <div class="min-h-screen bg-sky-50 flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white p-6 rounded-xl shadow-lg border">
            <h2 class="text-2xl font-bold text-center mb-4">Verifikasi Nomor WhatsApp</h2>

            {{-- Tampilkan pesan --}}
            @if (session('message'))
                <div class="mb-4 text-center text-sm font-semibold text-{{ session('success') ? 'green' : 'red' }}-600">
                    {{ session('message') }}
                </div>
            @endif

            @if (!session('otp_sent'))
                {{-- Form Kirim OTP --}}
                <form action="{{ route('otp.send') }}" method="POST">
                    @csrf
                    <label for="phone_number" class="block text-sm font-medium mb-1">Nomor WhatsApp</label>
                    <input type="text" name="phone_number" id="phone_number" class="w-full border rounded px-3 py-2 mb-3"
                        value="{{ $user->phone_number }}" required>

                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white py-2 px-4 rounded">
                        Kirim OTP
                    </button>
                </form>
            @else
                {{-- Form Verifikasi OTP --}}
                <form action="{{ route('otp.verify') }}" method="POST">
                    @csrf
                    <input type="hidden" name="phone_number" value="{{ session('phone_number') }}">

                    <label for="code" class="block text-sm font-medium mb-1">Kode OTP</label>
                    <input type="text" name="code" id="code" maxlength="6"
                        class="w-full border rounded px-3 py-2 mb-3" placeholder="6 digit OTP" required>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
                        Verifikasi OTP
                    </button>

                    <p class="text-sm text-gray-500 mt-3">OTP dikirim ke <strong>{{ session('phone_number') }}</strong></p>
                </form>
            @endif
        </div>
    </div>
@endsection
