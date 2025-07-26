<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::insert([
            [
                'title' => 'Pelatihan Literasi Digital',
                'description' => 'Acara edukasi penggunaan teknologi informasi untuk masyarakat umum.',
                'location' => 'Ruang Aula Utama, Perpustakaan Kota Solok',
                'start_at' => Carbon::now()->addDays(3)->setTime(9, 0),
                'end_at' => Carbon::now()->addDays(3)->setTime(12, 0),
                'poster' => 'posters/poster.jpeg',
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Bincang Buku: Perjalanan Minangkabau',
                'description' => 'Diskusi dan bedah buku bersama penulis lokal.',
                'location' => 'Ruang Diskusi, Lantai 2',
                'start_at' => Carbon::now()->addDays(7)->setTime(13, 30),
                'end_at' => Carbon::now()->addDays(7)->setTime(15, 30),
                'poster' => 'posters/poster.jpeg',
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Lomba Cerita Anak',
                'description' => 'Kompetisi bercerita untuk anak-anak usia sekolah dasar.',
                'location' => 'Ruang Anak, Perpustakaan Kota Solok',
                'start_at' => Carbon::now()->addDays(10)->setTime(10, 0),
                'end_at' => Carbon::now()->addDays(10)->setTime(12, 0),
                'poster' => 'posters/poster.jpeg',
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pelatihan Menulis Cerpen',
                'description' => 'Workshop intensif menulis cerita pendek bersama penulis nasional.',
                'location' => 'Ruang Kelas Kreatif, Lantai 3',
                'start_at' => Carbon::now()->addDays(-1)->setTime(14, 0),
                'end_at' => Carbon::now()->addDays(0)->setTime(17, 0),
                'poster' => 'posters/poster.jpeg',
                'status' => 'ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Nonton Bareng Film Edukasi',
                'description' => 'Pemutaran film edukatif untuk remaja dan diskusi setelahnya.',
                'location' => 'Ruang Multimedia',
                'start_at' => Carbon::now()->addDays(-3)->setTime(15, 0),
                'end_at' => Carbon::now()->addDays(-3)->setTime(17, 0),
                'poster' => 'posters/poster.jpeg',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pameran Buku Lokal',
                'description' => 'Pameran buku terbitan lokal dan hasil karya penulis Solok.',
                'location' => 'Lobi Utama Perpustakaan',
                'start_at' => Carbon::now()->addDays(14)->setTime(8, 0),
                'end_at' => Carbon::now()->addDays(14)->setTime(16, 0),
                'poster' => 'posters/poster.jpeg',
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kelas Public Speaking',
                'description' => 'Pelatihan dasar berbicara di depan umum untuk remaja.',
                'location' => 'Ruang Pelatihan, Lantai 2',
                'start_at' => Carbon::now()->addDays(9)->setTime(10, 0),
                'end_at' => Carbon::now()->addDays(9)->setTime(12, 0),
                'poster' => 'posters/poster.jpeg',
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}