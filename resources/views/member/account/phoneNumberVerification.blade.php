@extends('member.layouts.app')

@section('title', 'Verifikasi Nomor WhatsApp')

@section('content')
    <div class="min-h-screen bg-sky-50 flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white p-6 rounded-xl shadow-lg border">
            <h2 class="text-2xl font-bold text-center mb-4">Verifikasi Nomor WhatsApp</h2>

            {{-- Form Kirim OTP --}}
            <form class="flex flex-col" action="{{ route('otp.get') }}">
                <label for="phone_number" class="block text-sm font-medium mb-1">Nomor WhatsApp</label>
                <input type="text" name="phone_number" id="phone_number" class="w-full border rounded px-3 py-2 mb-3"
                    value="{{ $user->phone_number }}" required>

                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

                <div class="mx-auto">
                    <a href="https://wa.me/6281371006380?text=OTP" target="_blank">
                        <button
                            class="flex items-center gap-2 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-white" viewBox="0 0 24 24"
                                id="getOTP">
                                <path
                                    d="M20.52 3.48A11.91 11.91 0 0012 .001C5.37.001 0 5.37 0 12c0 2.11.55 4.15 1.6 5.96L.07 24l6.22-1.58A11.96 11.96 0 0012 24c6.63 0 12-5.37 12-12a11.91 11.91 0 00-3.48-8.52zM12 22.03c-1.9 0-3.76-.51-5.39-1.47l-.38-.23-3.69.94.99-3.59-.25-.37A9.96 9.96 0 012 12C2 6.49 6.49 2 12 2s10 4.49 10 10-4.49 10-10 10zm5.46-7.2c-.3-.15-1.78-.88-2.06-.98-.28-.1-.49-.15-.7.15s-.8.98-.98 1.18c-.18.2-.36.22-.66.07-.3-.15-1.26-.46-2.4-1.46-.89-.79-1.49-1.76-1.66-2.06-.17-.3-.02-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.7-1.67-.96-2.29-.25-.6-.5-.52-.7-.53l-.6-.01c-.2 0-.52.07-.8.37-.28.3-1.06 1.04-1.06 2.52s1.09 2.92 1.24 3.12c.15.2 2.14 3.27 5.19 4.58.73.31 1.3.5 1.74.64.73.23 1.39.2 1.92.12.59-.09 1.78-.73 2.04-1.43.25-.7.25-1.3.18-1.43-.07-.13-.26-.2-.56-.35z" />
                            </svg>
                            Hubungi WhatsApp Admin untuk OTP
                        </button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
