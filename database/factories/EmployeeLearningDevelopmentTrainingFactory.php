<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeLearningDevelopmentTraining;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeLearningDevelopmentTrainingFactory extends Factory
{
    protected $model = EmployeeLearningDevelopmentTraining::class;

    public function definition()
    {
        $dateFrom = \Carbon\Carbon::parse($this->faker->date())->format('d M, Y'); // Format 'date_from' as '20 Jan, 2025'
        $dateTo = \Carbon\Carbon::parse($this->faker->dateTimeThisYear('+1 year'))->format('d M, Y'); // Format 'date_to' as '20 Jan, 2025'

        // Ensure 'date_to' is after 'date_from'
        while (strtotime($dateTo) <= strtotime($dateFrom)) {
            $dateTo = \Carbon\Carbon::parse($this->faker->dateTimeThisYear('+1 year'))->format('d M, Y');
        }

        return [
            'emp_id' => Employee::inRandomOrder()->first()->emp_id, // Randomly assign emp_id from employees table
            'title' => $this->faker->word(),
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'number_of_hours' => $this->faker->numberBetween(1, 100), // Random number of hours
            'type_of_ld' => $this->faker->word(),
            'conducted_by' => $this->faker->company(),
        ];
    }
}
