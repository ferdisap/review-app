<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\User::factory()->create([
            'name' => 'Ferdi Arrahman',
            'username' => 'ferdisap',
            'email' => 'ferdisaptoko@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$eXI2mcuX.TgQENrdmwQfQep6F1R.Dt0ET9acG0aO.LNRpoCDmbDv6' // password
        ]);
    }
}
