<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    public function run()
    {
        School::create(['name' => 'School A']);
        School::create(['name' => 'School B']);
        // Add more schools as needed
    }
}