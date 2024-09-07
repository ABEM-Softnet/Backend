<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call the BranchSeeder
        $this->call(BranchSeeder::class);
        
        // Call other seeders, like StudentSeeder
        $this->call(StudentSeeder::class);
    }
}
