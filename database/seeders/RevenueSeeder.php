<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Branch;
use Faker\Factory as Faker;

class RevenueSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $branches = Branch::all();

        foreach ($branches as $branch) {
            DB::table('revenue')->insert([
                'branch_id' => $branch->id,
                'amount' => $faker->randomFloat(2, 100, 1000),
                'type' => $faker->randomElement(['registration_fee', 'monthly_fee', 'exam_fee']),
                'payment_method' => $faker->randomElement(['cash', 'digital_payment']),
                'date' => $faker->date,
            ]);
        }
    }
}