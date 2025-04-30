<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicantContact;
use App\Models\Applicant;

class ApplicantContactSeeder extends Seeder
{
    public function run()
    {
        $applicants = Applicant::all(); // Get all applicants

        foreach ($applicants as $applicant) {
            ApplicantContact::factory()->create([
                'app_id' => $applicant->app_id, // Ensure app_id matches applicants table
            ]);
        }
    }
}
