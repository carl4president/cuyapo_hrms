<?php

namespace Database\Factories;

use App\Models\ApplicantCivilServiceEligibility;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantCivilServiceEligibilityFactory extends Factory
{
    protected $model = ApplicantCivilServiceEligibility::class;

    public function definition()
    {
        return [
            'app_id' => function () {
                return Applicant::inRandomOrder()->first()->app_id;
            },
            'eligibility_type' => $this->faker->word(),
            'rating' => $this->faker->randomFloat(2, 70, 100),
            // Format 'exam_date' as '20 Jan, 2025'
            'exam_date' => \Carbon\Carbon::parse($this->faker->date())->format('d M, Y'),
            'exam_place' => $this->faker->city(),
            'license_number' => $this->faker->regexify('[A-Z0-9]{10}'),
            // Format 'license_validity' as '20 Jan, 2025'
            'license_validity' => \Carbon\Carbon::parse($this->faker->date())->format('d M, Y'),
        ];
    }
}
