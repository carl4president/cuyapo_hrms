<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeEducation;
use App\Models\Employee;

class EmployeeEducationSeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::all(); // Get all employees

        foreach ($employees as $employee) {
            EmployeeEducation::factory()->count(5)->create([
                'emp_id' => $employee->emp_id, // Ensure emp_id matches employees table
            ]);
        }
    }
}
