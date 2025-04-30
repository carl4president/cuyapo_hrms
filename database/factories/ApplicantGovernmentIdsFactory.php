<?php

namespace Database\Factories;

use App\Models\ApplicantGovernmentIds;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantGovernmentIdsFactory extends Factory
{
    protected $model = ApplicantGovernmentIds::class;

    public function definition()
    {
        return [
            'app_id' => function() {
                return Applicant::inRandomOrder()->first()->app_id; // Randomly choose an applicant's app_id
            },
            'agency_employee_no' => $this->faker->word(),
            'sss_no' => $this->faker->regexify('^[0-9]{10}$'),
            'gsis_id_no' => $this->faker->regexify('^[0-9]{12}$'),
            'pagibig_no' => $this->faker->regexify('^[0-9]{12}$'),
            'philhealth_no' => $this->faker->regexify('^[0-9]{12}$'),
            'tin_no' => $this->faker->regexify('^[0-9]{9}$'),
        ];
    }
}


