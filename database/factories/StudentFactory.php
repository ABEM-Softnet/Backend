<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student; // Ensure this is imported
use App\Models\Branch;

class StudentFactory extends Factory
{
    protected $model = Student::class; // Ensure this is correctly set

    public function definition()
    {
        return [
            'fullname' => $this->faker->name,
            'grade' => $this->faker->word,
            'enrollment_date' => $this->faker->date,
            'status' => $this->faker->word,
            'branch_id' => Branch::factory(), // Creates a new Branch record for each Student
        ];
    }
}
