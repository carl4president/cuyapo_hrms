<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeGovernmentId;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeGovernmentIdFactory extends Factory
{
    protected $model = EmployeeGovernmentId::class;

    public function definition()
    {
        return [
            'emp_id' => Employee::inRandomOrder()->first()->emp_id, // Ensure emp_id exists in employees table
            'agency_employee_no' => $this->faker->optional()->numerify('AEN-#####'),
            'sss_no' => $this->faker->optional()->numerify('##-#######-#'),
            'gsis_id_no' => $this->faker->optional()->numerify('GSIS-########'),
            'pagibig_no' => $this->faker->optional()->numerify('###########'),
            'philhealth_no' => $this->faker->optional()->numerify('###########'),
            'tin_no' => $this->faker->optional()->numerify('###-###-###'),
        ];
    }
}
