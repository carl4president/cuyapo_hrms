<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            EmployeeSeeder::class,
            EmployeeContactSeeder::class,
            EmployeeGovernmentIdSeeder::class,
            EmployeeEducationSeeder::class,
            EmployeeFamilyInfoSeeder::class,
            EmployeeChildSeeder::class,
            EmployeeCivilServiceEligibilitySeeder::class,
            EmployeeWorkExperienceSeeder::class,
            EmployeeVoluntaryWorkSeeder::class,
            EmployeeLearningDevelopmentTrainingSeeder::class,
            EmployeeOtherInformationSeeder::class,
            EmployeeEmploymentSeeder::class,
            AddJobSeeder::class,
            ApplicantSeeder::class,
            UserSeeder::class,
            ApplicantContactSeeder::class,
            ApplicantGovernmentIdsSeeder::class,
            ApplicantFamilyInfoSeeder::class,
            ApplicantEducationSeeder::class,
            ApplicantChildrenSeeder::class,
            ApplicantCivilServiceEligibilitySeeder::class,
            ApplicantVoluntaryWorkSeeder::class,
            ApplicantWorkExperienceSeeder::class,
            ApplicantLearningDevelopmentTrainingSeeder::class,
            ApplicantOtherInformationSeeder::class,
            ApplicantEmploymentSeeder::class,
        ]);
    }
    
}
