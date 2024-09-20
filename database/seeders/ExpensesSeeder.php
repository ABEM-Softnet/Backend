<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\School;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpensesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $branches = Branch::all();
        $schools = School::all();

        foreach ($branches as $branch) {
            foreach ($schools as $school) {
                DB::table('expenses')->insert([
                    'amount' => $faker->randomFloat(2, 100, 1000),
                    'type' => $faker->randomElement(['teachers_wage', 'materials']),
                    'date' => $faker->date,
                    'branch_id' => $branch->id,
                    'school_id' => $school->id,
                ]);
            }
        }
    }
}