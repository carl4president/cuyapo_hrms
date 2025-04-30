<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeEmployment;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeEmploymentFactory extends Factory
{
    protected $model = EmployeeEmployment::class;

    public function definition(): array
    {
        return [
            'emp_id' => Employee::inRandomOrder()->first()->emp_id,
            'employment_status' => $this->faker->randomElement(['Full Time', 'Temporary', 'Part Time']),
            // date_hired will be passed from seeder
        ];
    }
}

