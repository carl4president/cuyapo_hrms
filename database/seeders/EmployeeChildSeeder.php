<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeChild;
use App\Models\Employee;

class EmployeeChildSeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::all(); // Get all employees

        foreach ($employees as $employee) {
            // Create 2 random children for each employee (you can adjust the number of children)
            EmployeeChild::factory()->count(3)->create([
                'emp_id' => $employee->emp_id, // Ensure emp_id is aligned with the employee
            ]);
        }
    }
}

