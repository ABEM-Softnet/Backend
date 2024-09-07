<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Branch;

class BranchFactory extends Factory
{
    protected $model = Branch::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
        ];
    }
}
