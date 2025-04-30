<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeEmployment;
use App\Models\Employee;
use App\Models\EmployeeJobDetail;
use App\Models\Position;

class EmployeeEmploymentSeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            $hiredDate = fake()->date('Y-m-d'); 
            $formattedDate = \Carbon\Carbon::createFromFormat('Y-m-d', $hiredDate)->format('d M, Y');
            $position = Position::inRandomOrder()->first();

            // Create employment record
            EmployeeEmployment::factory()->create([
                'emp_id' => $employee->emp_id,
                'employment_status' => fake()->randomElement(['Full Time', 'Temporary', 'Part Time']),
                'date_hired' => $formattedDate,
            ]);

            // Create job detail record with same date
            EmployeeJobDetail::factory()->create([
                'emp_id' => $employee->emp_id,
                'position_id' => $position->id,
                'department_id' => $position->department_id,
                'appointment_date' => $formattedDate,
            ]);
        }
    }
}