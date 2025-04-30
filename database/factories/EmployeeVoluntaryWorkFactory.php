<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeVoluntaryWork;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeVoluntaryWorkFactory extends Factory
{
    protected $model = EmployeeVoluntaryWork::class;

    public function definition()
    {
        // Generate the 'from_date' first and format it as '20 Jan, 2025'
        $from_date = \Carbon\Carbon::parse($this->faker->date())->format('d M, Y');

        // Generate the 'to_date' as a date after the 'from_date' and format it as '20 Jan, 2025'
        $to_date = \Carbon\Carbon::parse($this->faker->dateTimeBetween($from_date, '+1 year'))->format('d M, Y');

        return [
            'emp_id' => Employee::inRandomOrder()->first()->emp_id, // Randomly assign emp_id from employees table
            'organization_name' => $this->faker->company(),
            'from_date' => $from_date,
            'to_date' => $to_date,
            'number_of_hours' => $this->faker->numberBetween(10, 100), // Random number of hours
            'position_nature_of_work' => $this->faker->word(),
        ];
    }
}
