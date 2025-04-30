<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeOtherInformation;
use App\Models\Employee;

class EmployeeOtherInformationSeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::all(); // Get all employees

        foreach ($employees as $employee) {
            // Create 1 random other information record for each employee (you can adjust the number)
            EmployeeOtherInformation::factory()->count(4)->create([
                'emp_id' => $employee->emp_id, // Ensure emp_id is aligned with the employee
            ]);
        }
    }
}

