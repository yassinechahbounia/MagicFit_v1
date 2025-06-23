<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\ExerciceController;
use App\Http\Controllers\SuiviController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| API Routes Laravel
|--------------------------------------------------------------------------
*/

// ✅ Authentification publique
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ✅ Routes protégées avec Sanctum
Route::middleware(['auth:sanctum'])->group(function () {

    // Déconnexion + profil
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // ✅ Programmes dynamiques selon rôle
    Route::middleware('auth:sanctum')->get('/programmes', [ProgrammeController::class, 'index']);
    Route::get('/programmes', function (Request $request) {
        $user = $request->user();

        return match ($user->role) {
            'admin' => response()->json([
                ['nom' => 'Admin Program 1', 'description' => 'Admin desc', 'image' => 'admin1.jpg'],
                ['nom' => 'Admin Program 2', 'description' => 'Admin desc', 'image' => 'admin2.jpg'],
            ]),
            'coach' => response()->json([
                ['nom' => 'Coach Program A', 'description' => 'For your clients', 'image' => 'coach1.jpg'],
            ]),
            default => response()->json([
                ['nom' => 'Losing Weight', 'description' => 'Burn fat easily', 'image' => '1.jpg'],
                ['nom' => 'Body Building', 'description' => 'Gain muscle', 'image' => '2.jpg'],
            ]),
        };
    });

    // ✅ Exercices
    Route::apiResource('exercices', ExerciceController::class)->only([
        'index',
        'store',
        'update',
        'destroy'
    ]);
    Route::get('/exercices/{id}', [ExerciceController::class, 'show']);


    // ✅ Suivis
    Route::apiResource('suivis', SuiviController::class)->only([
        'index',
        'store',
        'destroy'
    ]);

    Route::middleware('auth:sanctum')->get('/suivis', [SuiviController::class, 'index']);


    // ✅ Routes réservées aux coachs et admins
    Route::middleware('coach-or-admin')->group(function () {

        // 🔹 Programmes complets
        Route::get('/programmes', [ProgrammeController::class, 'index']);
        Route::get('/programmes/{id}', [ProgrammeController::class, 'show']);
        Route::get('/programmes/all', [ProgrammeController::class, 'index']);
        Route::post('/programmes', [ProgrammeController::class, 'store']);
        Route::put('/programmes/{id}', [ProgrammeController::class, 'update']);
        Route::delete('/programmes/{id}', [ProgrammeController::class, 'destroy']);

        // 🔹 Utilisateurs
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);


        //** Réservation Facile **//
        Route::middleware('auth:sanctum')->post('/reservations', [ReservationController::class, 'store']);
        Route::post('/reservations', [ReservationController::class, 'store']);
        Route::get('/reservations', [ReservationController::class, 'index']);
    });
});
