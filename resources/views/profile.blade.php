@extends('layouts.app')

@section('title', 'Profil | Perpustakaan Umum Kota Solok')

@section('content')
    <main>
        <div>
            <div class="w-full relative mx-auto overflow-hidden rounded-lg shadow-lg" x-data="carousel()"
                x-init="start()">
                <!-- Slides -->
                <div class="relative h-96">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="active === index"
                            class="absolute inset-0 transition-opacity duration-700 ease-in-out"
                            x-transition:enter="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
                            <img :src="slide.image" class="w-full h-full object-cover"
                                :alt="'Slide ' + (index + 1)">
                        </div>
                    </template>
                </div>

                <!-- Navigasi manual (opsional) -->
                <div class="absolute inset-0 flex justify-between items-center px-4">
                    <button @click="prev()" class="bg-black/30 hover:bg-black/50 text-white px-2 py-1 rounded-full">
                        &larr;
                    </button>
                    <button @click="next()" class="bg-black/30 hover:bg-black/50 text-white px-2 py-1 rounded-full">
                        &rarr;
                    </button>
                </div>

                <!-- Indicator -->
                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-2">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="active = index" :class="active === index ? 'bg-white' : 'bg-white/50'"
                            class="w-2 h-2 rounded-full">
                        </button>
                    </template>
                </div>
            </div>
            <!-- Sambutan -->
            <section class="py-16 px-2 sm:px-4 lg:px-6 w-full mx-auto bg-white">
                <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div>
                        <h2 class="text-4xl font-semibold text-gray-900 mb-3 leading-snug">
                            Selamat Datang di<br>
                            <span class="text-sky-800">Perpustakaan Umum Kota Solok</span>
                        </h2>
                    </div>

                    <div>
                        <p class="text-gray-700 text-lg leading-relaxed mb-7">
                            Perpustakaan Umum Kota Solok merupakan salah satu institusi penting di Kota Solok, Sumatera Barat, yang berperan sebagai pusat informasi, literasi, dan pembelajaran masyarakat. Dengan latar belakang budaya dan tradisi yang kaya, perpustakaan ini menjadi bagian dari upaya peningkatan kualitas pendidikan dan akses informasi yang inklusif bagi seluruh warga. Sebagai lembaga pendidikan non-formal, Perpustakaan Umum Kota Solok terus melakukan inovasi layanan guna menumbuhkan minat baca dan memperluas wawasan masyarakat dari berbagai kalangan. Dalam halaman ini, Anda dapat menjelajahi informasi lengkap terkait sejarah, visi dan misi, layanan yang tersedia, serta program-program unggulan yang dijalankan oleh perpustakaan ini.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Sejahtera -->
            <section class="py-16 px-2 sm:px-4 lg:px-6 w-full mx-auto bg-neutral-100">
                <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div>
                        <h2 class="text-4xl font-semibold text-gray-900 mb-3 leading-snug">
                            Sejarah<br>
                            <span class="text-sky-800">Perpustakaan Umum Kota Solok</span>
                        </h2>
                    </div>

                    <div class="text-gray-700 text-lg leading-relaxed space-y-4">
                        <p>
                            Dinas Perpustakaan dan Kearsipan Kota Solok awalnya bernama Kantor Arsip dan Perpustakaan Daerah atau disingkat dengan KAPD, yang didirikan pada tahun 2001 berdasarkan Peraturan Daerah Nomor 6. Kemudian dikuatkan dengan Peraturan Daerah Nomor 1 Tahun 2003 tentang bentuk dan susunan organisasi perangkat daerah dan Sekretariat DPRD kota Solok. Pada masa ini, Kantor Arsip dan Kantor Perpustakaan berada pada tempat yang berbeda.
                        </p>
                        <p>
                            Pada tahun 2009 Kantor Arsip dan Perpustakaan Daerah berubah nama menjadi Kantor Arsip Dokumentasi dan Perpustakaan (KADP) Kota Solok berdasarkan Peraturan Daerah Kota Solok Nomor 18 Tahun 2009. Perubahan ini merupakan gabungan dari Kantor Perpustakaan Umum dan Kantor Arsip Daerah yang sebelumnya terpisah. Pada tahun 2016, berdasarkan Peraturan Daerah Nomor 5 Tahun 2016 Tentang Pembentukan Dan Susunan Perangkat Daerah, Kantor Arsip Dokumentasi dan Perpustakaan berubah nama menjadi Dinas Perpustakaan dan Kearsipan Kota Solok hingga saat ini.
                        </p>
                        <p>
                            Berdasarkan Peraturan Walikota Solok Nomor 35 Tahun 2023 Tentang Kedudukan, Susunan Organisasi, Tugas dan Fungsi Serta Tata Kerja Dinas Perpustakaan dan Kearsipan pasal 2 ayat (1) menyebutkan bahwa Dinas merupakan unsur pelaksana urusan pemerintahan di bidang perpustakaan dan bidang kearsipan dipimpin oleh Kepala Dinas yang berkedudukan dan bertanggung jawab kepada Wali Kota melalui sekretaris Daerah.
                        </p>
                        <p>
                            Dinas Perpustakaan dan Kearsipan Kota Solok saat ini  berada di Lingkungan Balaikota Solok Gedung G,  Jalan Lubuk Sikarah, Kelurahan IX Korong, Kecamatan Lubuk Sikarah, Kota Solok. Perpustakaan Umum Kota Solok saat ini berada di Jalan. Natsir Sutan Pamuncak, Kelurahan Simpang Rumbio, Kecamatan Lubuk Sikarah Kota Solok
                        </p>
                    </div>

                </div>
            </section>

            {{-- Visi Misi --}}
            <section class="py-16 px-2 sm:px-4 lg:px-6 w-full mx-auto bg-white">
                <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div>
                        <h2 class="text-4xl font-semibold text-gray-900 mb-3 leading-snug">
                            Visi dan Misi<br>
                            <span class="text-sky-800">Perpustakaan Umum Kota Solok</span>
                        </h2>
                    </div>

                    <div>
                        <p class="text-gray-700 text-lg leading-relaxed mb-7">
                            Visi dan Misi Dinas Perpustakaan dan Kearsipan Kota Solok dalam mewujudkan Visi dan Misi Pemerintah Kota Solok yaitu:
                        </p>

                        <p class="text-gray-700 text-lg leading-relaxed mb-7 italic font-semibold">
                            “Terwujudnya Kota Solok Yang Diberkahi, Maju Dan Sejahtera Melalui Pengembangan Sektor Perdagangan Dan Jasa Yang Maju Modern”
                        </p>

                        <p class="text-gray-700 text-lg leading-relaxed mb-7">
                            Dalam rangka mewujudkan visi sebagaimana yang tersebut di atas maka diperlukan sebuah Misi yang memuat rumusan mengenai upaya-upaya yang akan dilaksanakan dan diwujudkan agar tujuan dapat dilaksanakan dan berhasil dengan baik sesuai Visi, maka Misi Dinas Perpustakaan dan Kearsipan ialah:
                        </p>

                        <ul class="list-decimal ml-8 text-gray-700 text-lg leading-relaxed text-justify space-y-2 mb-7">
                            <li>Peningkatan kualitas hidup masyarakat dengan meningkatkan derajat kesehatan, pendidikan dan perlindungan sosial.</li>
                            <li>Peningkatan kapasitas pemerintahan dan manajemen birokrasi yang bersih, efektif dan efisien.</li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script src="{{ asset('js/guest/profile.js') }}"></script>
@endsection
