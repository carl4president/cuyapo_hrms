<?php

namespace Database\Factories;

use App\Models\ApplicantContact;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantContactFactory extends Factory
{
    protected $model = ApplicantContact::class;

    public function definition()
    {
        return [
            'app_id' => function() {
                return Applicant::inRandomOrder()->first()->app_id;
            },
            'residential_address' => $this->faker->address(),
            'residential_zip' => $this->faker->numerify('####'), // 4-digit zip code
            'permanent_address' => $this->faker->address(),
            'permanent_zip' => $this->faker->numerify('####'), // 4-digit zip code
            'phone_number' => $this->faker->numerify('09## ### ####'), // Phone number with format
            'mobile_number' => $this->faker->numerify('09## ### ####'), // Mobile number with format
        ];
    }
}

