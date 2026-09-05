<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'mrsey9999@gmail.com'],
            [
                'name' => 'Pisey',
                'password' => Hash::make('P@ssw0rd'),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            SkillSeeder::class,
            ProjectSeeder::class,
            PostSeeder::class,
        ]);
    }
}
