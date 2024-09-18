<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Branch;
use Faker\Factory as Faker;

class ExpensesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $branches = Branch::all();

        foreach ($branches as $branch) {
            DB::table('expenses')->insert([
                'amount' => $faker->randomFloat(2, 100, 1000),
                'type' => $faker->randomElement(['teachers_wage', 'materials']),
                'date' => $faker->date,
                'branch_id' => $branch->id,
            ]);
        }
    }
}