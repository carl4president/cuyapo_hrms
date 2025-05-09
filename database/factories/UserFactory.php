<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = User::class;

    public function definition()
    {
        // Fetch a random employee
        $employee = Employee::inRandomOrder()->first();

        // Ensure there's a fallback if no employees exist
        return [
            'user_id' => $employee ? $employee->emp_id : 'CYP-0002', // Using emp_id from the Employee table
            'name' => $employee ? $employee->name : $this->faker->name,
            'first_name' => $employee->first_name,
            'middle_name' => $employee->middle_name,
            'last_name' => $employee->last_name,
            'email' => $employee ? $employee->email : $this->faker->unique()->safeEmail, // Using the employee's email or generating a fake one
            'avatar' => 'photo_defaults.jpg', // Random avatar
            'role_name' => 'Employee', // Default role
            'join_date' => now()->toDateString(), // Current date
            'status' => 'Active', // Default status
            'password' => bcrypt('password'), // Default password
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}