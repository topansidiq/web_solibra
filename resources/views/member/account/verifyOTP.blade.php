@extends('member.layouts.app')

@section('title', 'Verifikasi Nomor WhatsApp')

@section('content')
    <div class="min-h-screen bg-sky-50 flex items-center justify-center px-4">
        {{-- Tampilkan pesan --}}
        @if (session('message'))
            <div class="mb-4 text-center text-sm font-semibold text-{{ session('success') ? 'green' : 'red' }}-600">
                {{ session('message') }}
            </div>
        @endif
        <div class="w-full max-w-md bg-white p-6 rounded-xl shadow-lg border">
            <h2 class="text-2xl font-bold text-center mb-4">Verifikasi Nomor WhatsApp</h2>

            {{-- Form Verifikasi OTP --}}
            <form action="{{ route('otp.verify') }}" method="POST">
                @csrf
                <input type="hidden" name="phone_number" value="{{ session('phone_number') }}">
                <input type="hidden" name="user_id" value="{{ session('user_id') }}">

                <label for="code" class="block text-sm font-medium mb-1">Kode OTP</label>
                <input type="text" name="code" id="code" maxlength="6"
                    class="w-full border rounded px-3 py-2 mb-3" placeholder="6 digit OTP" required>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
                    Verifikasi OTP
                </button>

                <p class="text-sm text-gray-500 mt-3">OTP dikirim ke <strong>{{ session('phone_number') }}</strong></p>
            </form>
        </div>
        <script>
            const userId = document.getElementById('user_id').value;
            const phoneNumber = document.getElementById('phone_number').value;
            document.getElementById("getOTP").addEventListener("click", async function() {
                try {
                    const response = await fetch('https://localhost:8000/otp/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            user_id: userId,
                            phone_number: phoneNumber,
                        })
                    });

                    const result = await response.json();
                    if (response.ok) {
                        // Redirect ke WhatsApp dengan pesan "OTP"
                        window.location.href = `https://wa.me/6281371006380?text=OTP`;
                    } else {
                        alert(result.message || 'Terjadi kesalahan saat generate OTP.');
                    }
                } catch (error) {
                    console.error(error);
                    alert("Gagal menghubungi server.");
                }
            });
        </script>
    </div>
@endsection
