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
        <main class="lg:w-3/4 border border-sky-100 rounded-sm shadow-md p-4 bg-sky-50">

            <h1 class="text-center mb-5 text-lg font-bold text-neutral-700">Daftar Akun Baru</h1>

            @if ($errors->any())
                <div class="mb-4 text-red-600 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data"
                class="lg:grid lg:grid-cols-2 md:grid-cols-1 gap-4 space-y-2">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                        placeholder="Contoh: Budiono Siregar" value="{{ old('name') }}">
                </div>

                <div class="grid grid-cols-2 items-center content-between gap-2">
                    <div>
                        <label for="id_type" class="block text-sm font-medium text-gray-700 mb-1">Pilih
                            Identitas<span class="text-xs text-neutral-400">(Default KTP)</span> </label>
                        <select name="id_type" id="id_type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                            <option value="KTP">KTP</option>
                            <option value="Paspor">Paspor</option>
                            <option value="Kartu Pelajar">Kartu Pelajar</option>
                        </select>
                    </div>

                    <div>
                        <label for="id_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Identitas<span
                                class="text-xs text-neutral-400">(KTP)</span> </label>
                        <input type="text" name="id_number" id="id_number"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                            placeholder="Contoh: 1305072807020001" value="{{ old('id_number') }}">
                    </div>
                </div>
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <div
                        class="flex gap-6 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                        <div class="flex items-center content-center">
                            <input type="radio" name="gender" value="male">
                            <p class="text-sm pl-1">Laki-laki</p>
                        </div>
                        <div class="flex items-center content-center">
                            <input type="radio" name="gender" value="male">
                            <p class="text-sm pl-1">Perempuan</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 items-center content-between gap-2">
                    <div>
                        <label for="place_birth" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir <span
                                class="text-xs text-neutral-400">(Sesuai KTP)</span> </label>
                        <input type="text" name="place_birth" id="place_birth" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                            placeholder="Contoh: Solok" value="{{ old('place_birth') }}">
                    </div>
                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span
                                class="text-xs text-neutral-400">(Sesuai KTP)</span> </label>
                        <input type="date" name="birth_date" id="birth_date" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                            placeholder="Contoh: 12/12/2012" value="{{ old('birth_date') }}">
                    </div>
                </div>
                <div>
                    <label for="education" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan</label>
                    <select name="education" id="education"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                        <option disabled>Pilih Pendidikan Terakhir</option>
                        <option value="Tidak ada">
                            Tidak ada
                        </option>
                        <option value="SD">
                            SD
                        </option>
                        <option value="SMP">
                            SMP
                        </option>
                        <option value="SMA/SMK">
                            SMA/SMK
                        </option>
                        <option value="Diploma III">
                            Diploma III
                        </option>
                        <option value="Diploma IV">
                            Diploma IV
                        </option>
                        <option value="S1">
                            S1
                        </option>
                        <option value="Magister Terapan">
                            Magister Terapan
                        </option>
                        <option value="S2">
                            S2
                        </option>
                        <option value="S3">
                            S3
                        </option>
                        <option disabled>
                            Pendidikan Khusus
                        </option>
                        <option value="Akademisi">
                            Akademisi
                        </option>
                        <option value="Akademisi">
                            Sertifikasi
                        </option>
                    </select>
                </div>

                <div>
                    <label for="jpb" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                    <input type="text" name="jpb" id="jpb"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                        placeholder="Contoh: Mahasiswa/Pelajar" value="{{ old('jpb') }}">
                </div>

                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp
                        <span class="text-xs text-neutral-400">(Harus Aktif)</span> </label>
                    <input type="text" name="phone_number" id="phone_number" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                        placeholder="Contoh: 081234567890" value="{{ old('phone_number') }}">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                        placeholder="Contoh: email@gmail.com" value="{{ old('email') }}">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" required autocomplete="new-password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                        placeholder="Masukkan Password: minimal 8 karakter">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        autocomplete="current-password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                        placeholder="Konfirmasi password">
                </div>

                <input type="hidden" value="member" name="role">

                <div class="col-span-2 w-2xl mx-auto flex flex-col items-center justify-around">
                    <div>
                        <button type="submit"
                            class="w-60 bg-sky-600 text-white py-2 px-4 rounded-lg hover:bg-sky-800 transition duration-200">
                            Daftar
                        </button>
                    </div>

                    <div class="text-center text-sm text-gray-600 mt-4">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-sky-600 hover:underline">Masuk</a>
                    </div>
                </div>
            </form>
        </main>


        <footer class="w-full bg-sky-800">
            <div class="border-t text-center text-xs text-neutral-300 py-4">
                Copyright © 2025. All Right Reserved By <span class="font-semibold">Perpustakaan Umum Kota Solok</span>
            </div>
        </footer>
    </div>
</body>

</html>
