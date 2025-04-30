<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicantLearningDevelopmentTraining;
use App\Models\Applicant;

class ApplicantLearningDevelopmentTrainingSeeder extends Seeder
{
    public function run()
    {
        $applicants = Applicant::all(); // Get all applicants

        foreach ($applicants as $applicant) {
            // Create 1 random learning and development training record for each applicant
            ApplicantLearningDevelopmentTraining::factory()->count(3)->create([
                'app_id' => $applicant->app_id, // Link training to the applicant
            ]);
        }
    }
}
