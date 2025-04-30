<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicantWorkExperience;
use App\Models\Applicant;

class ApplicantWorkExperienceSeeder extends Seeder
{
    public function run()
    {
        $applicants = Applicant::all(); // Get all applicants

        foreach ($applicants as $applicant) {
            $workExperienceCount = rand(2, 5); // Assign 1 to 3 work experience records per applicant
            ApplicantWorkExperience::factory()->count($workExperienceCount)->create([
                'app_id' => $applicant->app_id, // Link work experience to the applicant
            ]);
        }
    }
}
