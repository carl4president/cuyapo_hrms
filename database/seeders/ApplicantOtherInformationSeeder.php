<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicantOtherInformation;
use App\Models\Applicant;

class ApplicantOtherInformationSeeder extends Seeder
{
    public function run()
    {
        $applicants = Applicant::all(); // Get all applicants

        foreach ($applicants as $applicant) {
            $infoCount = rand(2, 5); // Assign 1 to 3 other information records per applicant
            ApplicantOtherInformation::factory()->count($infoCount)->create([
                'app_id' => $applicant->app_id, // Link the other information to the applicant
            ]);
        }
    }
}
