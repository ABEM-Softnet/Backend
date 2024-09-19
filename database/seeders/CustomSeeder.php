<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CustomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Here the method calls the system admin seeder
        $this->callOnce(SystemAdminSeeder::class);

        //Here  method calls the grade division seeder
        $this->callOnce(GradeDivisionSeeder::class);

        //Here  method calls the school seeder
        $this->callOnce(SchoolSeeder::class);

        //Here  method calls the branch  seeder
        $this->callOnce(BranchSeeder::class);

    }
}
