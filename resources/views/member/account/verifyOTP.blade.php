@extends('member.layouts.app')

@section('title', 'Verifikasi Nomor WhatsApp')

@section('content')
    {{-- Alert Error --}}
    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold bg-red-300 px-2 py-1 rounded-sm">Gagal</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    <div class="min-h-screen bg-sky-50 flex items-center justify-center px-4">


        <div class="w-full max-w-md bg-white p-6 rounded-xl shadow-lg border">
            <h2 class="text-2xl font-bold text-center mb-4">Verifikasi Nomor WhatsApp</h2>

            {{-- Form Verifikasi OTP --}}
            <form action="{{ route('member.verifing') }}" method="POST">
                @csrf
                <input type="hidden" name="phone_number" value="{{ $user->phone_number }}">
                <label for="code" class="block text-sm font-medium mb-1">Kode OTP</label>
                <input type="text" name="code" id="code" maxlength="6"
                    class="w-full border rounded px-3 py-2 mb-3" placeholder="6 digit OTP" required>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
                    Verifikasi OTP
                </button>
            </form>
        </div>
    </div>
@endsection
