<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name,
            'grade' => $this->faker->numberBetween(1, 12),
            'section' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'score' => $this->faker->randomFloat(2, 0, 100),
            'total_days_present' => $this->faker->numberBetween(0, 200),
            'total_days_absent' => $this->faker->numberBetween(0, 50),
            'days_present_this_month' => $this->faker->numberBetween(0, 30),
            'days_present_this_week' => $this->faker->numberBetween(0, 7),
            'is_newcomer' => $this->faker->boolean,
            'branch_id' => Branch::inRandomOrder()->first()->id, 
        ];
    }
}
