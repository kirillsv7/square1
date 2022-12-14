<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory()->create([
            'name'  => 'admin',
            'email' => 'admin@square1.io',
        ]);
        User::factory()->create([
            'name'  => 'author',
            'email' => 'author@square1.io',
        ]);

        $this->call([
            UserSeeder::class,
            PostSeeder::class,
        ]);

        cache()->flush();
    }
}
