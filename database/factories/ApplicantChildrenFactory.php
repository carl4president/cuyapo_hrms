<?php

namespace Database\Factories;

use App\Models\ApplicantChildren;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantChildrenFactory extends Factory
{
    protected $model = ApplicantChildren::class;

    public function definition()
    {
        return [
            'app_id' => function () {
                return Applicant::inRandomOrder()->first()->app_id;
            },
            'child_name' => $this->faker->name(),
            // Format 'child_birthdate' as '20 Jan, 2025'
            'child_birthdate' => \Carbon\Carbon::parse($this->faker->date())->format('d M, Y'),
        ];
    }
}
