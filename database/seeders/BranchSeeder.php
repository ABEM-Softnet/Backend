<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run()
    {
        Branch::create(['name' => 'Branch A', 'location' => 'Location A', 'school_id' => 1]);
        Branch::create(['name' => 'Branch B', 'location' => 'Location B', 'school_id' => 1]);
    }
}