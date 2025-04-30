<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeVoluntaryWork;
use App\Models\Employee;

class EmployeeVoluntaryWorkSeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::all(); // Get all employees

        foreach ($employees as $employee) {
            // Create 1 random voluntary work for each employee (you can adjust the number)
            EmployeeVoluntaryWork::factory()->count(1)->create([
                'emp_id' => $employee->emp_id, // Ensure emp_id is aligned with the employee
            ]);
        }
    }
}

