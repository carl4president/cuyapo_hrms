<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicantFamilyInfo;
use App\Models\Applicant;

class ApplicantFamilyInfoSeeder extends Seeder
{
    public function run()
    {
        $applicants = Applicant::all(); // Get all applicants

        foreach ($applicants as $applicant) {
            ApplicantFamilyInfo::factory()->create([
                'app_id' => $applicant->app_id, // Link family info to the applicant
            ]);
        }
    }
}
