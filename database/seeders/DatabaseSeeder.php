<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(5)->create();

        \App\Models\User::factory()->create([
            'name' => 'Ilham Maulana',
            'email' => 'k4ilham@gmail.com',
        ]);

        \App\Models\Barang::factory(50)->create();

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    }
}
