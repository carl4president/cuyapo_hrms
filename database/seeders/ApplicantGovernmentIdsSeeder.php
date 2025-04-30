<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicantGovernmentIds;
use App\Models\Applicant;

class ApplicantGovernmentIdsSeeder extends Seeder
{
    public function run()
    {
        $applicants = Applicant::all(); // Get all applicants

        foreach ($applicants as $applicant) {
            ApplicantGovernmentIds::factory()->create([
                'app_id' => $applicant->app_id, // Link the government ID to the applicant
            ]);
        }
    }
}
