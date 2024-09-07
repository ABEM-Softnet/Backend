<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run()
    {
        Branch::factory()->count(10)->create();
        Student::factory()->count(30)->create();
    }
}
