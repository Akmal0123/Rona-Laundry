<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \App\Models\User::create([
            'nama_user'   => 'Super Admin',
            'email'       => 'admin@rona.com',
            'password'    => bcrypt('admin123'),
            'no_whatsapp' => '085700000001',
            'alamat'      => 'Jl. Admin, No. 1, Kota Rona',
            'role'        => 'admin',
        ]);
    }
}
