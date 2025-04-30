<?php

namespace Database\Factories;

use App\Models\ApplicantFamilyInfo;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantFamilyInfoFactory extends Factory
{
    protected $model = ApplicantFamilyInfo::class;

    public function definition()
    {
        return [
            'app_id' => function() {
                return Applicant::inRandomOrder()->first()->app_id;
            },
            'father_name' => $this->faker->name(),
            'mother_name' => $this->faker->name(),
            'spouse_name' => $this->faker->name(),
            'spouse_occupation' => $this->faker->word(),
            'spouse_employer' => $this->faker->company(),
            'spouse_business_address' => $this->faker->address(),
            'spouse_tel_no' => $this->faker->phoneNumber(),
        ];
    }
}

