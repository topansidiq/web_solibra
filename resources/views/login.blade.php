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

            <h1 class="text-center mb-5 text-lg font-bold text-neutral-700">Login</h1>

            @if (session('error'))
                <div class="mb-4 text-red-600 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mx-auto">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email/Nomor Telepon</label>
                    <input type="text" name="email" required autofocus
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                        placeholder="Masukkan email atau nomor telepon" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                        placeholder="Masukkan password/kata sandi anda">
                    @error('password')
                        <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="form-checkbox text-teal-600">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>

                    <a href="#" class="text-sm text-sky-600 hover:underline">Lupa Password?</a>
                </div>

                <input type="hidden" name="role_id">

                <div>
                    <button type="submit"
                        class="w-full bg-sky-600 text-white py-2 px-4 rounded-lg hover:bg-sky-800 transition duration-200">
                        Masuk
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                Belum memiliki akun?
                <a href="#" class="text-sky-600 hover:underline">Daftar</a>
            </div>


        </main>

        <footer class="w-full bg-sky-800">
            <div class="border-t text-center text-xs text-sky-100 py-4">
                Copyright © 2025. All Right Reserved By <span class="font-semibold">Perpustakaan Umum Kota Solok</span>
            </div>
        </footer>
    </div>
</body>

</html>
