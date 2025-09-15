<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // === ADMIN ===
        User::updateOrCreate(
            ['email' => 'admin@lms.test'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // === GURU ===
        User::updateOrCreate(
            ['email' => 'guru@lms.test'],
            [
                'name' => 'Guru Satu',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]
        );

        // === SISWA ===
        User::updateOrCreate(
            ['email' => 'siswa@lms.test'],
            [
                'name' => 'Siswa Pertama',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]
        );
    }
}
