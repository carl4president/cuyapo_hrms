<?php

namespace Database\Factories;

use App\Models\AddJob;
use App\Models\Position;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddJobFactory extends Factory
{
    protected $model = AddJob::class;

    public function definition()
    {

        $jobTypes = ['Full Time', 'Part Time', 'Internship', 'Temporary', 'Remote', 'Others'];
        $statuses = ['Open', 'Closed', 'Cancelled'];

        $position = Position::inRandomOrder()->first();


        return [
            'position_id' => $position->id,
            'department_id' => $position->department_id,
            'no_of_vacancies' => $this->faker->numberBetween(1, 10),
            'experience' => $this->faker->word(),
            'age' => $this->faker->numberBetween(20, 40),
            'salary_from' => $this->faker->numberBetween(10000, 50000),
            'salary_to' => $this->faker->numberBetween(50000, 100000),
            'job_type' => $this->faker->randomElement($jobTypes),
            'status' => $this->faker->randomElement($statuses),
            
            // Dates in 'd M, Y' format
            'start_date' => now()->format('d M, Y'),
            'expired_date' => now()->addDays(rand(1, 120))->format('d M, Y'),
        
            'description' => $this->faker->paragraph(),
            'count' => $this->faker->text(),
        ];
        
    }
}

