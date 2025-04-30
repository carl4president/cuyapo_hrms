<?php

namespace Database\Factories;

use App\Models\ApplicantVoluntaryWork;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantVoluntaryWorkFactory extends Factory
{
    protected $model = ApplicantVoluntaryWork::class;

    public function definition()
    {
        // Generate from_date first
        $fromDate = $this->faker->dateTimeThisDecade();  // You can adjust this if you need a specific range

        // Ensure to_date is later than from_date and format it as '20 Jan, 2025'
        $toDate = $this->faker->dateTimeBetween($fromDate, 'now');

        return [
            'app_id' => function () {
                return Applicant::inRandomOrder()->first()->app_id;
            },
            'organization_name' => $this->faker->company(),
            // Format from_date as '20 Jan, 2025'
            'from_date' => $fromDate->format('d M, Y'),
            // Format to_date as '20 Jan, 2025'
            'to_date' => $toDate->format('d M, Y'),
            'number_of_hours' => $this->faker->randomDigitNotNull(),
            'position_nature_of_work' => $this->faker->word(),
        ];
    }
}
