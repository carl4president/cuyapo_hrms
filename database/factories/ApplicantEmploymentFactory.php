<?php

namespace Database\Factories;

use App\Models\ApplicantEmployment;
use App\Models\Applicant;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantEmploymentFactory extends Factory
{
    protected $model = ApplicantEmployment::class;

    public function definition()
    {
        return [
            'app_id' => function() {
                return Applicant::inRandomOrder()->first()->app_id;  // Ensure a random app_id from applicants
            },
            'department_id' => function() {
                return Department::inRandomOrder()->first()->id;  // Ensure a random department_id
            },
            'position_id' => function() {
                return Position::inRandomOrder()->first()->id;  // Ensure a random position_id
            },
            'employment_status' => $this->faker->randomElement(['Active', 'Inactive', 'On Leave']),
            'status' => 'New',  // Default value for status
        ];
    }
}

