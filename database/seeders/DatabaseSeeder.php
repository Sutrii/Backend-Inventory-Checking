<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::factory()->count(1)->create();

        // Atau, jika Anda hanya ingin membuat pengguna tertentu
        // User::factory()->create([
        //     'name' => 'Test',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('password'), // bcrypt untuk hashing password
        // ]);
    }
}
