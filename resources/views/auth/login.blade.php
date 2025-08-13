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
            <h1 class="text-center text-lg font-bold text-neutral-200 mx-auto">{{ __('main.puks') }}</h1>
            <p class="text-center mx-auto text-xs text-neutral-300">{{ __('main.slogan') }}</p>
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="text" name="email" required autofocus
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                        placeholder="{{ __("auth.enter_email") }}" value="{{ old('email') }}"
                        autocomplete="email">
                    @error('email')
                        <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6" x-data="{ show: false }">
                    <label class="block text-sm font-medium
                    text-gray-700 mb-2">{{ __('auth.password') }}</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" id="password" name="password" required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm pr-10"
                            placeholder="{{ __('auth.enter_password') }}" autocomplete="current-password">

                        <!-- Tombol toggle -->
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                            <template x-if="show">
                                <i data-lucide="eye-off" class="w-5 h-5"></i>
                            </template>
                            <template x-if="!show">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </template>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="form-checkbox text-teal-600">
                        <span class="ml-2 text-sm text-gray-600">{{ __('auth.remember_me') }}</span>
                    </label>
                    <a href="{{ route('password.forgot') }}" class="text-sm text-sky-600 hover:underline">{{ __('auth.forgot_password') }}</a>
                </div>

                <input type="hidden" name="role_id">

                <div>
                    <button type="submit"
                        class="w-full bg-sky-600 text-white py-2 px-4 rounded-lg hover:bg-sky-800 transition duration-200">
                        {{ __('auth.enter') }}
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                {{ __('auth.dont_have_account') }}
                <a href="{{ route('register') }}" class="text-sky-600 hover:underline">{{ __('auth.register') }}</a>
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
