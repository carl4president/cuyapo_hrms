<?php

namespace Database\Factories;

use App\Models\ApplicantLearningDevelopmentTraining;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantLearningDevelopmentTrainingFactory extends Factory
{
    protected $model = ApplicantLearningDevelopmentTraining::class;

    public function definition()
    {
        // Generate date_from first in the format '20 Jan, 2025'
        $date_from = $this->faker->dateTimeThisDecade();

        return [
            'app_id' => function () {
                return Applicant::inRandomOrder()->first()->app_id;
            },
            'title' => $this->faker->word(),
            // Format 'date_from' as '20 Jan, 2025'
            'date_from' => $date_from->format('d M, Y'),
            // Generate 'date_to' to be after 'date_from' and format it as '20 Jan, 2025'
            'date_to' => $this->faker->dateTimeBetween($date_from, '+1 year')->format('d M, Y'),
            'number_of_hours' => $this->faker->randomDigitNotNull(),
            'type_of_ld' => $this->faker->word(),
            'conducted_by' => $this->faker->company(),
        ];
    }
}
