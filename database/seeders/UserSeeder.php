<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Employee;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Fetch employees
        $employees = Employee::all();

        foreach ($employees as $employee) {
            // Check if the email already exists in the users table
            if (User::where('email', $employee->email)->exists()) {
                $email = \Faker\Generator::unique()->safeEmail; // Generate a unique email
            } else {
                $email = $employee->email; // Use employee's email if not duplicate
            }

            // Create user with non-duplicate email
            User::factory()->create([
                'user_id' => $employee->emp_id,
                'name' => $employee->name,
                'first_name' => $employee->first_name,
                'middle_name' => $employee->middle_name,
                'last_name' => $employee->last_name,
                'email' => $email,
            ]);
        }
    }
}

