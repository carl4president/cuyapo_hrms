<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Applicant;

class ApplicantSeeder extends Seeder
{
    public function run()
    {
        // Adjust the count based on how many applicants you want to create
        Applicant::factory()->count(20)->create(); // Create 20 sample applicants
    }
}
