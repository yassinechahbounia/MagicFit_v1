<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Exercice;

class ExerciceSeeder extends Seeder
{
    public function run()
    {
        $exercices = [
            ['nom' => 'Squat', 'description' => 'Strengthens legs and glutes'],
            ['nom' => 'Push-up', 'description' => 'Chest and triceps workout'],
            ['nom' => 'Plank', 'description' => 'Core stability exercise'],
            ['nom' => 'Lunges', 'description' => 'Lower body strengthening'],
            ['nom' => 'Jumping Jacks', 'description' => 'Full-body cardio warm-up'],
            ['nom' => 'Burpees', 'description' => 'Explosive cardio movement'],
            ['nom' => 'Mountain Climbers', 'description' => 'Cardio and core focus'],
            ['nom' => 'Sit-ups', 'description' => 'Abdominal exercise'],
            ['nom' => 'Pull-up', 'description' => 'Upper back and biceps'],
            ['nom' => 'Dips', 'description' => 'Triceps and chest'],
        ];

        foreach ($exercices as $ex) {
            Exercice::firstOrCreate(
                ['nom' => $ex['nom']],
                [
                    'description' => $ex['description'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );
        }
    }
}
