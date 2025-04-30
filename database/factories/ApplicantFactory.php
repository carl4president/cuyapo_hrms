<?php

namespace Database\Factories;

use App\Models\Applicant;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantFactory extends Factory
{
    protected $model = Applicant::class;

    public function definition()
    {

        $firstName = $this->faker->firstName;
        $middleName = $this->faker->firstName;
        $lastName = $this->faker->lastName;


        return [
            'app_id' => $this->faker->unique()->numerify('APP-#####'),
            'name' => $firstName . ' ' . $middleName . ' ' . $lastName,
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'birth_date' => \Carbon\Carbon::parse($this->faker->date())->format('d M, Y'),
            'place_of_birth' => $this->faker->city(),
            'height' => $this->faker->numberBetween(150, 200), // Height in cm
            'weight' => $this->faker->numberBetween(40, 120),  // Weight in kg
            'blood_type' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'civil_status' => $this->faker->randomElement(['Single', 'Married', 'Divorced', 'Widowed']),
            'nationality' => $this->faker->country(),
            'photo' => 'photo_defaults.jpg',
        ];
    }
}
