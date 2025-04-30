<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ApplicantChildren;
use App\Models\Applicant;

class ApplicantChildrenSeeder extends Seeder
{
    public function run()
    {
        $applicants = Applicant::all(); // Get all Applicants

        foreach ($applicants as $applicant) {
            // Create 2 random children for each Applicant (you can adjust the number of children)
            ApplicantChildren::factory()->count(2)->create([
                'app_id' => $applicant->app_id, // Ensure app_id is aligned with the Applicant
            ]);
        }
    }
}

