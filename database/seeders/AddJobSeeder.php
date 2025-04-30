<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AddJob;
use App\Models\Position;

class AddJobSeeder extends Seeder
{
    public function run()
    {
        $positions = Position::all();

        foreach ($positions as $position) {
            AddJob::factory()->create([
                'position_id' => $position->id,
                'department_id' => $position->department_id, // assumes position has department_id
            ]);
        }
    }
}
