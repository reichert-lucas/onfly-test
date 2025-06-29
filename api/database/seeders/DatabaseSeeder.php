<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SystemSeeder::class);
        $this->call(TravelOrderStatusSeeder::class);
        $this->call(UserSeeder::class);
    }
}
