<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Department;
use App\Models\EmployeeJobDetail;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeJobDetailFactory extends Factory
{
    protected $model = EmployeeJobDetail::class;

    public function definition(): array
    {
        $position = Position::inRandomOrder()->first();

        return [
            // emp_id, appointment_date will be passed from seeder
            'position_id'   => $position->id,
            'department_id' => $position->department_id,
        ];
    }
}
