<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeChild;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeChildFactory extends Factory
{
    protected $model = EmployeeChild::class;

    public function definition()
    {
        return [
            'emp_id' => Employee::inRandomOrder()->first()->emp_id, // Randomly assign an emp_id from employees table
            'child_name' => $this->faker->name(),
            // Format 'child_birthdate' as '20 Jan, 2025'
            'child_birthdate' => \Carbon\Carbon::parse($this->faker->date())->format('d M, Y'),
        ];
    }
}
