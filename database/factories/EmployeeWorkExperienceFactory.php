<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeWorkExperience;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeWorkExperienceFactory extends Factory
{
    protected $model = EmployeeWorkExperience::class;

    public function definition()
    {
        // Generate the 'from_date' first and format it as '20 Jan, 2025'
        $fromDate = \Carbon\Carbon::parse($this->faker->date())->format('d M, Y');

        // Generate the 'to_date' as a date after 'from_date' and format it as '20 Jan, 2025'
        $toDate = \Carbon\Carbon::parse($this->faker->dateTimeBetween($fromDate, '+1 year'))->format('d M, Y');

        return [
            'emp_id' => Employee::inRandomOrder()->first()->emp_id, // Randomly assign emp_id from employees table
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'position_title' => $this->faker->jobTitle(),
            'department_agency_office_company' => $this->faker->company(),
            'monthly_salary' => $this->faker->randomFloat(2, 10000, 50000), // Monthly salary between 10,000 to 50,000
            'salary_grade' => $this->faker->word(),
            'status_of_appointment' => $this->faker->word(),
            'govt_service' => $this->faker->boolean(50), // Random boolean for govt service
        ];
    }
}
