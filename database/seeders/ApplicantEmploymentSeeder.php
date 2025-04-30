<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicantEmployment;
use App\Models\Applicant;

class ApplicantEmploymentSeeder extends Seeder
{
    public function run()
    {
        $applicants = Applicant::all(); // Get all applicants

        foreach ($applicants as $applicant) {
            ApplicantEmployment::factory()->create([
                'app_id' => $applicant->app_id, // Link employment record to the applicant
            ]);
        }
    }
}
