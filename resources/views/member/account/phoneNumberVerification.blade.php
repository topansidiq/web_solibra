@extends('member.layouts.app')

@section('title', 'Verifikasi Nomor WhatsApp')

@section('content')
    <div class="bg-sky-50 px-4 grid items-center justify-center gap-10 p-16">
        <div class="grid w-[700px] bg-white p-6 rounded-lg shadow border border-neutral-300 mx-auto">
            <div class="grid gap-3">
                <div class="flex items-center gap-1">
                    <i data-lucide="message-circle-warning"></i>
                    <h1 class="text-lg font-bold">Info</h1>
                </div>
                <p class="text-sm">
                    Untuk melakukan verifikasi nomor WhatsApp silahkan klik tombol hijau Dapatkan OTP dibawah. Anda akan di
                    arahkan ke chatbot. Ketikkan <b>OTP</b> untuk meminta kode OTP. Anda juga bisa langsung mendatangi
                    Perpustakaan dan menjumpai admin untuk melakukan verifikasi.
                </p>
            </div>
        </div>

        <div class="grid w-full max-w-sm mx-auto bg-white p-6 rounded-xl shadow-lg border border-neutral-300">
            <h2 class="text-xl font-bold text-center mb-4">Verifikasi Nomor WhatsApp</h2>

            {{-- Form Kirim OTP --}}
            <form class="flex flex-col" action="{{ route('otp.get') }}">
                <label for="phone_number" class="block text-sm font-medium mb-1 text-center">Masukkan Nomor WhatsApp</label>
                <input type="text" name="phone_number" id="phone_number"
                    class="w-full border border-neutral-400 rounded px-3 py-2 mb-3" value="{{ $user->phone_number }}"
                    required>

                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
            </form>
            <div class="flex mx-auto gap-4 text-sm">
                <div class="bg-green-500 py-2 px-4 rounded-lg text-neutral-50">
                    <a href="https://wa.me/6282388407308?text=OTP" target="_blank">
                        <button class="">
                            Dapatkan OTP
                        </button>
                    </a>
                </div>
                <div class="bg-sky-700 py-2 px-4 rounded-lg text-neutral-50">
                    <a href="{{ route('member.verification.otp') }}">
                        Verifikasi OTP
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
