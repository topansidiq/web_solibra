@extends('layouts.app')

@section('title', 'Layanan | Perpustakaan Umum Kota Solok')

@section('content')
<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col items-center text-center mb-14">
            <h2 class="text-3xl font-extrabold text-sky-800">Layanan Kami</h2>
            <p class="text-gray-500 mt-2">Menyediakam berbagai layanan untuk mendukung literasi masyarakat</p>
            <div class="w-20 border-b-4 border-sky-600 mt-3"></div>
        </div>

        <!-- Grid Layanan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="iteration-cw" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Sirkulasi</h3>
                <p class="text-gray-700 text-sm">Peminjaman, pengembalian, dan perpanjangan masa pinjam bahan pustaka.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="square-user-round" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Keanggotaan</h3>
                <p class="text-gray-700 text-sm">Proses pendaftaran mudah untuk menjadi anggota perpustakaan.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="blocks" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Koleksi Anak</h3>
                <p class="text-gray-700 text-sm">Bahan bacaan edukatif dan hiburan untuk anak-anak.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="users" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Koleksi Umum</h3>
                <p class="text-gray-700 text-sm">Buku populer, fiksi, non-fiksi, dan buku pelajaran untuk semua kalangan.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="bot" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Chatbot</h3>
                <p class="text-gray-700 text-sm">Asisten virtual informasi peminjaman dan perpanjangan masa pinjam buku</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="bookmark-check" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Referensi</h3>
                <p class="text-gray-700 text-sm">Kamus, ensiklopedia, dan bahan rujukan hanya untuk dibaca di tempat.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="book-copy" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Tandon</h3>
                <p class="text-gray-700 text-sm">Koleksi cadangan atau arsip pustaka untuk kondisi tertentu.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="accessibility" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Pemustaka Berkebutuhan Khusus</h3>
                <p class="text-gray-700 text-sm">Layanan inklusif bagi penyandang disabilitas.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="speech" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Pengaduan</h3>
                <p class="text-gray-700 text-sm">Kritik, saran, dan keluhan untuk meningkatkan kualitas layanan.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="file-clock" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Solok Corner</h3>
                <p class="text-gray-700 text-sm">Informasi sejarah, budaya, dan perkembangan Kota Solok.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="search" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Temu Kembali Informasi</h3>
                <p class="text-gray-700 text-sm">Bantuan menemukan informasi dari katalog manual atau digital.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="laptop-minimal" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Warintek</h3>
                <p class="text-gray-700 text-sm">Warung Informasi Teknologi, akses informasi ilmiah dan teknologi melalui internet.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="bus" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Perpustakaan Keliling</h3>
                <p class="text-gray-700 text-sm">Mobil perpustakaan untuk menjangkau daerah terpencil.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="refresh-ccw" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Buku Bergulir</h3>
                <p class="text-gray-700 text-sm">Peminjaman koleksi buku bergiliran di komunitas.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-200">
                <i data-lucide="baby" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                <h3 class="text-lg font-semibold text-sky-800 mb-2">Layanan Literasi Anak Usia Dini</h3>
                <p class="text-gray-700 text-sm">Program membaca bersama, bercerita, dan aktivitas kreatif untuk anak.</p>
            </div>
        </div>
    </div>
</section>

<!-- Jadwal Layanan -->
<section class="py-12 bg-white">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-sky-800 mb-6 text-center">Jadwal Pelayanan</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Senin - Jumat -->
            <div class="bg-sky-800 text-white rounded-lg p-6 text-center shadow">
                <h3 class="text-lg font-semibold">Senin - Jum'at</h3>
                <p class="mt-2 text-sm">09.00 – 16.00 WIB</p>
            </div>

            <!-- Sabtu - Minggu -->
            <div class="bg-sky-800 text-white rounded-lg p-6 text-center shadow">
                <h3 class="text-lg font-semibold">Sabtu, Minggu & Tanggal Merah</h3>
                <p class="mt-2 text-sm">Tutup</p>
            </div>
        </div>
    </div>
</section>

@endsection
