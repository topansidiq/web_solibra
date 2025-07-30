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

        // User::factory(200)->create();

        // User::create([
        //     'name' => "Topan Sidiq",
        //     'email' => 'topansidiq28@gmail.com',
        //     'id_number' => "1305072807020002",
        //     'email_verified_at' => now(),
        //     'phone_number' => '082288404233',
        //     'phone_number_verified' => 'verified',
        //     'role' => Role::Admin,
        //     'password' => Hash::make('Salsabila2311'),
        //     'remember_token' => "topan12345",
        // ]);

        User::create([
            'name' => 'Salsabila Agustin Putri Yendi',
            'role' => 'member',
            'phone_number' => '082388407308',
            'gender' => 'P',
            'birth_date' => '2002-07-28',
            'age' => 23,
            'id_type' => 'KTP',
            'id_number' => 1305072807020001,
            'address' => 'Jl. Contoh No. 123, Padang',
            'regency' => 'Padang',
            'province' => 'Sumatera Barat',
            'member_status' => 'aktif',
            'jobs' => 'Mahasiswa',
            'education' => 'S1',
            'class_department' => 'Ilmu Perpustakaan',
            'email' => 'salsabilaagustingpy@gmail.com',
            'password' => Hash::make('Salsabila2311'),
            'remember_token' => 'topan12345',
            'status_account' => 'active',
            'expired_date' => now()->addYear(),
            'profile_picture' => null,
        ]);
    }
}
