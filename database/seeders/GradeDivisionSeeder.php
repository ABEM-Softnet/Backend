<?php

namespace Database\Seeders;

use App\Models\GradeDivision;
use Database\Factories\GradeDivisionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            'Nursery-UKG',
            '1-4',
            '5-8',
            '9-10',
            '11-12',
            'Nursery-4',
            'Nursery-8',
            'Nursery-10',
            'Nursery-12',
            '1-8',
            '1-10',
            '1-12',
            '5-10',
            '5-12',
            '9-12'
        ];


        foreach ($array as $key) {
            GradeDivision::factory()->create([
                'division' => $key
            ]);
        }

        
    }
}
