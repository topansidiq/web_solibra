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
    <div x-data="{ show: {{ session('error') ? 'true' : 'false' }} }" x-show="show" x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition
        x-cloak>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold bg-red-300 px-2 py-1 rounded-sm">{{ __('validation.failed') }}</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    </div>
    <div x-data="{ show: {{ session('success') ? 'true' : 'false' }} }" x-show="show" x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition
        x-cloak>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold bg-green-300 px-2 py-1 rounded-sm">{{ __('validation.success') }}</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    </div>
    <div class="flex flex-col items-center justify-between h-screen">
        <header class="bg-sky-800 text-neutral-50 items-center content-center border-b border-gray-50 p-4 w-full">
            <h1 class="text-center text-lg font-bold text-neutral-200 mx-auto">Perpustakaan Umum Kota Solok</h1>
            <p class="text-center mx-auto text-xs text-neutral-300">Sumber Literasi Terkini</p>
        </header>
        <main class="lg:w-xl w-96 border border-sky-100 rounded-sm shadow-md mt-20 p-6 bg-sky-50">


            <h1 class="text-center mb-5 text-lg font-bold text-neutral-700">Lupa Password</h1>

            <form method="POST" action="{{ route('password.link') }}" class="mx-auto">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email/Nomor Telepon</label>
                    <input type="text" name="phone_number" required autofocus
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                        placeholder="Masukkan email atau nomor telepon">
                    @error('email')
                        <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <input type="hidden" name="role">

                <div>
                    <button type="submit"
                        class="w-full bg-sky-600 text-white py-2 px-4 rounded-lg hover:bg-sky-800 transition duration-200">
                        Kirim Reset Link
                    </button>
                </div>
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
