<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->count(40)->create();

        // User::create([
        //     'name' => 'Salsabila Agustin Putri Yendi',
        //     'role' => 'member',
        //     'phone_number' => '082388407308',
        //     'gender' => 'female',
        //     'birth_date' => '2004-08-03',
        //     'age' => 23,
        //     'id_type' => 'KTP',
        //     'id_number' => 1305072807020001,
        //     'address' => 'Jl. Contoh No. 123, Padang',
        //     'regency' => 'Padang',
        //     'province' => 'Sumatera Barat',
        //     'member_status' => 'aktif',
        //     'jobs' => 'Mahasiswa',
        //     'education' => 'S1',
        //     'class_department' => 'Ilmu Perpustakaan',
        //     'email' => 'salsabilaagustinnpy@gmail.com',
        //     'password' => Hash::make('Salsabila2311'),
        //     'remember_token' => 'topan12345',
        //     'status_account' => 'active',
        //     'expired_date' => now()->addYear(),
        //     'profile_picture' => null,
        //     'email_verified_at' => now()
        // ]);

        // User::create([
        //     'name' => 'Salsabila Agustin PY',
        //     'role' => 'admin',
        //     'phone_number' => '089626861033',
        //     'gender' => 'male',
        //     'birth_date' => '2002-07-28',
        //     'age' => 23,
        //     'id_type' => 'KTP',
        //     'id_number' => 1305072807020002,
        //     'address' => 'Jl. Contoh No. 123, Padang',
        //     'regency' => 'Padang',
        //     'province' => 'Sumatera Barat',
        //     'member_status' => 'new',
        //     'jobs' => 'Mahasiswa',
        //     'education' => 'S1',
        //     'class_department' => 'Ilmu Perpustakaan',
        //     'email' => 'fahri@gmail.com',
        //     'password' => Hash::make('12345678'),
        //     'remember_token' => '123456789098',
        //     'status_account' => 'active',
        //     'expired_date' => now()->addYear(),
        //     'profile_picture' => null,
        //     'email_verified_at' => now()
        // ]);

        // User::create([
        //     'name' => "Primary",
        //     'role' => 'master',
        //     'phone_number' => '-',
        //     'email' => 'perpustakaankotasolok@gmail.com',
        //     'password' => Hash::make('perpustakaanumumkotasolok')
        // ]);
    }
}