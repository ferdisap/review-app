<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;
use PharIo\Manifest\Author;

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
        
        Post::factory(150)->create();

        Category::factory(1)->create();

        // \App\Models\Post::factory(50)->create([
        //   'isDraft' => 0,
        //   'author' => 1
        // ]);
        // \App\Models\Post::factory(50)->create([
        //   'isDraft' => 1,
        //   'author' => 1
        // ]);

        
    }
}
