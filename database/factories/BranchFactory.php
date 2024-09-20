<?php

namespace Database\Factories;


use App\Models\GradeDivision;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
class BranchFactory extends Factory
{

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
