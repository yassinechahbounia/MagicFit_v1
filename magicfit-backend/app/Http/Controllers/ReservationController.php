<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Reservation::latest()->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'nom' => 'required|string',
        'email' => 'required|email',
        'type' => 'required|in:Cours Collectif,Coaching Privé',
        'date' => 'required|date',
        'heure' => 'required'
    ]);

    // Convertir les types reçus du front en valeurs ENUM compatibles
    $mappedType = [
        'Cours Collectif' => 'collectif',
        'Coaching Privé' => 'prive'
    ];

    $validated['type'] = $mappedType[$validated['type']] ?? 'collectif';

    $reservation = \App\Models\Reservation::create($validated);

    return response()->json(['message' => 'Réservation créée avec succès'], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
