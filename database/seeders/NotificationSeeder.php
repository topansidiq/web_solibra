<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user dulu. Bisa juga langsung buat user palsu:
        User::factory()->count(10)->create()->each(function ($user) {
            // Setiap user dapat 5 notifikasi
            Notification::factory()->count(5)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
