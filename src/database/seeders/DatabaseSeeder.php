<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AreaSeeder;
use Database\Seeders\GenreSeeder;
use Database\Seeders\ShopSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    private const SEEDERS = [
        AreaSeeder::class,
        GenreSeeder::class,
        ShopSeeder::class,
        UserSeeder::class,
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        foreach (self::SEEDERS as $seeder) {
            $this->call($seeder);
        }
    }
}
