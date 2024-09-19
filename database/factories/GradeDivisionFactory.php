<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeDivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'division' => fake()->randomElement([
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
            ])
        ];
    }
}
