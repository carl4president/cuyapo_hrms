<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeEducation;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeEducationFactory extends Factory
{
    protected $model = EmployeeEducation::class;

    public function definition()
    {
        $educationLevels = ['Elementary', 'Secondary', 'Vocational/Trade Course', 'College', 'Graduate Studies'];
        $degrees = ['BS Computer Science', 'BS Information Technology', 'MBA', 'PhD in Computer Science'];
        $yearFrom = $this->faker->numberBetween(2000, 2015);
        $yearTo = $yearFrom + $this->faker->numberBetween(1, 5);

        // Set default values for each education level
        $educationLevel = $this->faker->randomElement($educationLevels);
        $education = [
            'emp_id' => Employee::inRandomOrder()->first()->emp_id, // Ensure emp_id exists in employees table
            'education_level' => $educationLevel,
            'school_name' => $this->faker->company . ' University',
            'year_from' => $yearFrom,
            'year_to' => $yearTo,
            'year_graduated' => $this->faker->boolean(80) ? $yearTo : null, // 80% chance of having graduated
            'scholarship_honors' => $this->faker->optional()->sentence(3),
        ];

        // Handle specific fields based on the education level
        switch ($educationLevel) {
            case 'Elementary':
            case 'Secondary':
                // Fields common to Elementary and Secondary
                $education['degree'] = null; // These levels typically don’t have a degree
                break;

            case 'Vocational/Trade Course':
                // Fields for Vocational/Trade Course
                $education['degree'] = $this->faker->randomElement($degrees);
                $education['highest_units_earned'] = $this->faker->numerify('## Units');
                break;

            case 'College':
                // Fields for College
                $education['degree'] = $this->faker->randomElement($degrees);
                $education['highest_units_earned'] = $this->faker->optional()->numerify('## Units');
                break;

            case 'Graduate Studies':
                // Fields for Graduate Studies
                $education['degree'] = $this->faker->randomElement($degrees);
                $education['highest_units_earned'] = $this->faker->optional()->numerify('## Units');
                break;
        }

        return $education;
    }
}
