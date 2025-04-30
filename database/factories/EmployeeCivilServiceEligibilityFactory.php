<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeCivilServiceEligibility;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeCivilServiceEligibilityFactory extends Factory
{
    protected $model = EmployeeCivilServiceEligibility::class;

    public function definition()
    {
        return [
            'emp_id' => Employee::inRandomOrder()->first()->emp_id, // Randomly assign an emp_id from employees table
            'eligibility_type' => $this->faker->word(),
            'rating' => $this->faker->randomFloat(2, 75, 100), // Rating between 75.00 to 100.00
            // Format 'exam_date' as '20 Jan, 2025'
            'exam_date' => \Carbon\Carbon::now()->format('d M, Y'),
            // Format 'exam_place' as a city
            'exam_place' => $this->faker->city(),
            'license_number' => $this->faker->uuid(),
            // Format 'license_validity' as '20 Jan, 2025'
            'license_validity' => \Carbon\Carbon::now()->addYears(5)->format('d M, Y'),
        ];
    }
}
