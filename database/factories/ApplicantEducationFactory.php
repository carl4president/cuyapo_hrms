<?php

namespace Database\Factories;

use App\Models\ApplicantEducation;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantEducationFactory extends Factory
{
    protected $model = ApplicantEducation::class;

    public function definition()
    {
        $educationLevels = ['Elementary', 'Secondary', 'Vocational/Trade Course', 'College', 'Graduate Studies'];
        $degrees = ['BS Computer Science', 'BS Information Technology', 'MBA', 'PhD in Computer Science'];

        $yearFrom = $this->faker->numberBetween(2000, 2015);
        $yearTo = $yearFrom + $this->faker->numberBetween(1, 5);

        // Determine the education level
        $educationLevel = $this->faker->randomElement($educationLevels);

        // Set up base data that is common across education levels
        $data = [
            'app_id' => Applicant::inRandomOrder()->first()->app_id, // Ensure app_id exists in employees table
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
                $data['degree'] = null; // No degree for these levels
                break;

            case 'Vocational/Trade Course':
                $data['degree'] = $this->faker->randomElement(['Vocational Certificate', 'Diploma']);
                $data['highest_units_earned'] = $this->faker->optional()->numerify('## Units');
                break;

            case 'College':
                $data['degree'] = $this->faker->randomElement($degrees);
                $data['highest_units_earned'] = $this->faker->optional()->numerify('## Units');
                break;

            case 'Graduate Studies':
                $data['degree'] = $this->faker->randomElement(['Masters', 'Doctorate']);
                $data['highest_units_earned'] = $this->faker->optional()->numerify('## Units');
                break;
        }

        return $data;
    }
}
