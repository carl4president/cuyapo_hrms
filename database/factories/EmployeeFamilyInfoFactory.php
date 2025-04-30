<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeFamilyInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFamilyInfoFactory extends Factory
{
    protected $model = EmployeeFamilyInfo::class;

    public function definition()
    {
        return [
            'emp_id' => Employee::inRandomOrder()->first()->emp_id, // Ensure emp_id exists in employees table
            'father_name' => $this->faker->name('male'),
            'mother_name' => $this->faker->name('female'),
            'spouse_name' => $this->faker->optional()->name(),
            'spouse_occupation' => $this->faker->optional()->jobTitle(),
            'spouse_employer' => $this->faker->optional()->company(),
            'spouse_business_address' => $this->faker->optional()->address(),
            'spouse_tel_no' => $this->faker->optional()->phoneNumber(),
        ];
    }
}

