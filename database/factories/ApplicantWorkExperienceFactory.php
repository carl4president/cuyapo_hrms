<?php

namespace Database\Factories;

use App\Models\ApplicantWorkExperience;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantWorkExperienceFactory extends Factory
{
    protected $model = ApplicantWorkExperience::class;

    public function definition()
    {
        return [
            'app_id' => function () {
                return Applicant::inRandomOrder()->first()->app_id;
            },
            // Generate 'from_date' and format it as '20 Jan, 2025'
            'from_date' => \Carbon\Carbon::now()->subYears(rand(1, 10))->format('d M, Y'),
            'to_date' => function (array $attributes) {
                // Parse the 'from_date' and ensure 'to_date' is later
                $fromDate = \Carbon\Carbon::createFromFormat('d M, Y', $attributes['from_date']);
                return $fromDate->addDays(rand(1, 365))->format('d M, Y'); // Adds a random number of days (1 to 365) and formats as '20 Jan, 2025'
            },
            'position_title' => $this->faker->jobTitle(),
            'department_agency_office_company' => $this->faker->company(),
            'monthly_salary' => $this->faker->randomFloat(2, 15000, 80000),
            'salary_grade' => $this->faker->word(),
            'status_of_appointment' => $this->faker->word(),
            'govt_service' => $this->faker->boolean(),
        ];
    }
}
