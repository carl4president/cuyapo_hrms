<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeContact;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeContactFactory extends Factory
{
    protected $model = EmployeeContact::class;

    public function definition()
    {
        return [
            'emp_id' => Employee::inRandomOrder()->first()->emp_id, // Ensure emp_id exists in employees table
            'residential_address' => $this->faker->address,
            'residential_zip' => $this->faker->randomNumber(4, true), // 4 digits zip
            'permanent_address' => $this->faker->address,
            'permanent_zip' => $this->faker->randomNumber(4, true), // 4 digits zip
            'phone_number' => $this->faker->optional()->numerify('09## ### ####'), // Phone number format
            'mobile_number' => $this->faker->numerify('09## ### ####'), // Mobile number format
        ];
    }
}
