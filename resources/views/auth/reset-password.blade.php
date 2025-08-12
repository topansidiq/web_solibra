<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Perpustakaan Umum Kota Solok</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    <div class="flex flex-col items-center justify-between h-screen">
        <header class="bg-sky-800 text-neutral-50 items-center content-center border-b border-gray-50 p-4 w-full">
            <h1 class="text-center text-lg font-bold text-neutral-200 mx-auto">Perpustakaan Umum Kota Solok</h1>
            <p class="text-center mx-auto text-xs text-neutral-300">Sumber Literasi Terkini</p>
        </header>
        <main class="lg:w-xl w-96 border border-sky-100 rounded-sm shadow-md mt-20 p-6 bg-sky-50">

            <h1 class="text-center mb-5 text-lg font-bold text-neutral-700">Lupa Password</h1>

            @if (session('error'))
                <div class="mb-4 text-red-600 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.reset') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <label>Password Baru</label>
                <input type="password" name="password" required>

                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required>

                <button type="submit">Reset Password</button>
            </form>
        </main>

        <footer class="w-full bg-sky-800">
            <div class="border-t text-center text-xs text-sky-100 py-4">
                Copyright © 2025. All Right Reserved By <span class="font-semibold">Perpustakaan Umum Kota Solok</span>
            </div>
        </footer>
    </div>
</body>

</html>
