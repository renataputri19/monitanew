<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Call the TimelineEventSeeder
        $this->call(TimelineEventSeeder::class);
        $this->call(DomainSeeder::class);
        $this->call(UserSeeder::class);
    }
}
