<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition()
    {
        return [
            'position_name' => $this->faker->jobTitle(), // Random position title
            'department_id' => Department::inRandomOrder()->first()->id, // Random department id
        ];
    }
}

