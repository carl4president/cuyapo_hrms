<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeWorkExperience;
use App\Models\Employee;

class EmployeeWorkExperienceSeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::all(); // Get all employees

        foreach ($employees as $employee) {
            // Create 1 random work experience for each employee (you can adjust the number)
            EmployeeWorkExperience::factory()->count(1)->create([
                'emp_id' => $employee->emp_id, // Ensure emp_id is aligned with the employee
            ]);
        }
    }
}

