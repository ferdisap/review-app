<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    \App\Models\User::factory()->create([
      'name' => 'Sambo',
      'username' => 'sambo',
      'email' => 'sambo@yahoo.com',
      'email_verified_at' => now(),
      'password' => '$2y$10$eXI2mcuX.TgQENrdmwQfQep6F1R.Dt0ET9acG0aO.LNRpoCDmbDv6' // password
    ]);
  }
}
