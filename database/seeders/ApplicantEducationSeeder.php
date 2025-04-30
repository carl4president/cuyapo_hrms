<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ApplicantEducation;
use App\Models\Applicant;

class ApplicantEducationSeeder extends Seeder
{
    public function run()
    {
        $applicants = Applicant::all(); // Get all applicants

        foreach ($applicants as $applicant) {
            ApplicantEducation::factory()->count(5)->create([
                'app_id' => $applicant->app_id, // Ensure app_id matches applicants table
            ]);
        }
    }
}
