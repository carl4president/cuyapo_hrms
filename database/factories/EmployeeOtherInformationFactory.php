<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeOtherInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeOtherInformationFactory extends Factory
{
    protected $model = EmployeeOtherInformation::class;

    public function definition()
    {
        return [
            'emp_id' => Employee::inRandomOrder()->first()->emp_id, // Randomly assign emp_id from employees table
            'special_skills_hobbies' => $this->faker->sentence(),
            'non_academic_distinctions' => $this->faker->sentence(),
            'membership_associations' => $this->faker->sentence(),
        ];
    }
}

