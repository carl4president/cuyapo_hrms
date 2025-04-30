<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeGovernmentId;
use App\Models\Employee;

class EmployeeGovernmentIdSeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::all(); // Get all employees

        foreach ($employees as $employee) {
            EmployeeGovernmentId::factory()->create([
                'emp_id' => $employee->emp_id, // Ensure emp_id matches employees table
            ]);
        }
    }
}

