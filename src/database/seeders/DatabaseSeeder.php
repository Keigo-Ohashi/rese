<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AreaSeeder;

class DatabaseSeeder extends Seeder
{
    private const SEEDERS = [
        AreaSeeder::class,
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
