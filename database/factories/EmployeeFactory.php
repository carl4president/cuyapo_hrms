<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        static $empCounter = 3; // Start from KH-0003

        $firstName = $this->faker->firstName;
        $middleName = $this->faker->firstName;
        $lastName = $this->faker->lastName;

        return [
            'emp_id' => 'CYP-' . str_pad($empCounter++, 4, '0', STR_PAD_LEFT), // Auto-increment KH-xxxx
            'name' => $firstName . ' ' . $middleName . ' ' . $lastName,
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'email' => $this->faker->unique()->safeEmail,
            'birth_date' => \Carbon\Carbon::parse($this->faker->date())->format('d M, Y'),
            'place_of_birth' => $this->faker->city,
            'height' => $this->faker->randomFloat(2, 1.4, 2.4), // Between 1.4m and 2.4m
            'weight' => $this->faker->randomFloat(1, 40, 120), // Between 40kg and 120kg
            'blood_type' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'civil_status' => $this->faker->randomElement(['Single', 'Married', 'Divorced', 'Widowed']),
            'nationality' => 'Filipino',
        ];
    }
}
