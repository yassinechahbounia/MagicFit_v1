<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Programme;
use App\Models\Exercice;

class ProgrammeSeeder extends Seeder
{
    public function run()
    {
        // Exemple d'exercices globaux (à créer une seule fois)
        $squat = Exercice::firstOrCreate(['nom' => 'Squat']);
        $pushup = Exercice::firstOrCreate(['nom' => 'Push-up']);
        $plank = Exercice::firstOrCreate(['nom' => 'Plank']);
        $jumpingJacks = Exercice::firstOrCreate(['nom' => 'Jumping Jacks']);
        $lunges = Exercice::firstOrCreate(['nom' => 'Lunges']);

        // Créer un programme
        $programme = Programme::create([
            'nom' => 'Training at Home',
            'description' => 'No gym? No problem. Workout programs for your living room.',
            'categorie' => 'Fitness',
            'image' => 'home.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Associer les exercices à ce programme
        $programme->exercices()->attach([
            $squat->id,
            $pushup->id,
            $plank->id,
            $jumpingJacks->id,
            $lunges->id
        ]);
    }
}

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Carbon;

// class ProgrammeSeeder extends Seeder
// {
//     public function run()
//     {
//         DB::table('programmes')->insert([
//             [
//                 'nom' => 'Basic Strength',
//                 'description' => 'Ideal for beginners',
//                 'categorie' => 'Fitness',
//                 'image' => 'basic.jpg',
//                 'created_at' => Carbon::now(),
//                 'updated_at' => Carbon::now(),
//             ],
//             [
//                 'nom' => 'Muscle Gain',
//                 'description' => 'Build serious muscle',
//                 'categorie' => 'Musculation',
//                 'image' => 'muscle.jpg',
//                 'created_at' => Carbon::now(),
//                 'updated_at' => Carbon::now(),
//             ],
//             [
//                 'nom' => 'Fat Burner',
//                 'description' => 'Lose weight fast',
//                 'categorie' => 'Cardio',
//                 'image' => 'fatburn.jpg',
//                 'created_at' => Carbon::now(),
//                 'updated_at' => Carbon::now(),
//             ],
//             [
//                 'nom' => 'Losing Fat',
//                 'description' => 'Effective training and coaching to help you burn fat.',
//                 'categorie' => 'Fitness',
//                 'image' => '1.jpg',
//                 'created_at' => Carbon::now(),
//                 'updated_at' => Carbon::now(),
//             ],
//             [
//                 'nom' => 'Body Building',
//                 'description' => 'Build muscle mass through strength training.',
//                 'categorie' => 'Musculation',
//                 'image' => '2.jpg',
//                 'created_at' => Carbon::now(),
//                 'updated_at' => Carbon::now(),
//             ],
//               [
//                 'nom' => 'TRAINING AT HOME',
//                 'description' => 'Build muscle mass through strength training.',
//                 'categorie' => 'Musculation',
//                 'image' => '2.jpg',
//                 'created_at' => Carbon::now(),
//                 'updated_at' => Carbon::now(),
//             ],
//         ]);
//     }
// }







// use Illuminate\Database\Seeder;
// use Illuminate\Support\Carbon;
// use App\Models\Programme;
// use App\Models\Exercice;

// class ProgrammeSeeder extends Seeder
// {
//     public function run()
//     {
//         $programme = Programme::create([
//             'nom' => 'Training at Home',
//             'description' => 'No gym? No problem. Workout programs for your living room.',
//             'categorie' => 'Fitness',
//             'image' => 'home.jpg',
//             'objectif' => 'Stay active and fit from home with minimal equipment.',
//             'nutrition' => [
//                 'Balanced diet',
//                 'Home-cooked meals',
//                 'Avoid junk food'
//             ],
//             'created_at' => Carbon::now(),
//             'updated_at' => Carbon::now(),
//         ]);

//         $programme->exercices()->createMany([
//             ['nom' => 'Push-ups'],
//             ['nom' => 'Squats'],
//             ['nom' => 'Lunges'],
//             ['nom' => 'Plank'],
//             ['nom' => 'Jumping Jacks'],
//         ]);
//     }
// }
