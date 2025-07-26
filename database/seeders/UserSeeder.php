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

        User::factory(20)->create();

        User::create([
            'name' => "Topan Sidiq",
            'email' => 'topansidiq28@gmail.com',
            'id_number' => "1305072807020002",
            'email_verified_at' => now(),
            'phone_number' => '082288404233',
            'phone_number_verified' => 'verified',
            'role_id' => 1,
            'password' => Hash::make('Salsabila2311'),
            'remember_token' => "topan12345",
        ]);

        User::create([
            'name' => "Salsabila Agustin Putri Yendi",
            'email' => 'salsabilaagustinpy@gmail.com',
            'id_number' => "1305072807020001",
            'email_verified_at' => null,
            'phone_number' => '082388407308',
            'phone_number_verified' => 'unverified',
            'role_id' => 4,
            'password' => Hash::make('Salsabila2311'),
            'remember_token' => "topan12345",
        ]);
    }
}