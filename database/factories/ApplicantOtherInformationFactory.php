<?php

namespace Database\Factories;

use App\Models\ApplicantOtherInformation;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantOtherInformationFactory extends Factory
{
    protected $model = ApplicantOtherInformation::class;

    public function definition()
    {
        return [
            'app_id' => function() {
                return Applicant::inRandomOrder()->first()->app_id;
            },
            'special_skills_hobbies' => $this->faker->sentence(),
            'non_academic_distinctions' => $this->faker->sentence(),
            'membership_associations' => $this->faker->sentence(),
        ];
    }
}

