<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicantCivilServiceEligibility;
use App\Models\Applicant;

class ApplicantCivilServiceEligibilitySeeder extends Seeder
{
    public function run()
    {
        $applicants = Applicant::all(); // Get all applicants

        foreach ($applicants as $applicant) {
            // Create 1 civil service eligibility per applicant
            ApplicantCivilServiceEligibility::factory()->count(3)->create([
                'app_id' => $applicant->app_id, // Use the correct foreign key
            ]);
        }
    }
}
