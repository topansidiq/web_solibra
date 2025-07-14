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
    <header
        class="w-full bg-teal-500 text-gray-900 p-4 h-32 mx-auto items-center content-center border-b border-gray-600">
        <h1 class="text-2xl text-center font-semibold border-b border-gray-600 pb-2 w-fit mx-auto">Selamat Datang di
            Perpustakaan
            Umum
            Kota Solok</h1>
        <p class="text-center max-w-xl mx-auto text-xs pt-2">Lorem ipsum dolor sit amet consectetur, adipisicing elit.
            Sumber Literasi Terkini</p>
    </header>
    <main class="max-w-6xl m-auto xl:pt-52">

        @if (session('error'))
            <div class="mb-4 text-red-600 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="max-w-2xl mx-auto">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email/Nomor Telepon</label>
                <input type="email" name="email" required autofocus
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                    placeholder="Masukkan email atau nomor telepon" value="{{ old('email') }}">
                @error('email')
                    <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                    placeholder="Masukkan password">
                @error('password')
                    <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="form-checkbox text-teal-600">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>

                <a href="#" class="text-sm text-teal-600 hover:underline">Forgot
                    Password?</a>
            </div>

            <input type="hidden" name="role_id">

            <div>
                <button type="submit"
                    class="w-full bg-teal-600 text-white py-2 px-4 rounded-lg hover:bg-teal-700 transition duration-200">
                    Login
                </button>
            </div>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            Don't have an account?
            <a href="#" class="text-teal-600 hover:underline">Register</a>
        </div>


    </main>

    <footer class="bottom-0 absolute w-full bg-teal-500">
        <div class="border-t text-center text-sm text-gray-600 py-4">
            Copyright © 2025. All Right Reserved By Perpustakaan Umum Kota Solok
        </div>
    </footer>
</body>

</html>
