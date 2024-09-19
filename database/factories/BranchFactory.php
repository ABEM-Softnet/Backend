<?php

namespace Database\Factories;

use App\Models\GradeDivision;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'school_id' => School::inRandomOrder()->first()->id,
            'grade_division_id' => GradeDivision::inRandomOrder()->first()->id,
            'name' => $this->faker->name,
            'location' => $this->faker->city,
        ];
    }
}
