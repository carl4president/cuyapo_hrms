<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicantVoluntaryWork;
use App\Models\Applicant;

class ApplicantVoluntaryWorkSeeder extends Seeder
{
    public function run()
    {
        $applicants = Applicant::all(); // Get all applicants

        foreach ($applicants as $applicant) {
            $voluntaryWorkCount = rand(2, 5); // Assign 1 to 3 voluntary work records per applicant
            ApplicantVoluntaryWork::factory()->count($voluntaryWorkCount)->create([
                'app_id' => $applicant->app_id, // Link voluntary work to the applicant
            ]);
        }
    }
}
