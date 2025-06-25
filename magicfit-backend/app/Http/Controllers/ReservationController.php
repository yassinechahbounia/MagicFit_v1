<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // 🔄 Lister toutes les réservations
    public function index()
    {
        return Reservation::all();
    }

    // ➕ Ajouter une réservation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required|in:Cours Collectif,Coaching Privé',
            'date' => 'required|date',
            'heure' => 'required'
        ]);

        $reservation = Reservation::create($validated);
        return response()->json($reservation, 201);
    }

    // 🔄 Modifier une réservation
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required|in:Collectif,Privé',
            'date' => 'required|date',
            'heure' => 'required'
        ]);

        $reservation->update($validated);
        return response()->json(['message' => 'Réservation modifiée avec succès']);
    }

    // 🗑️ Supprimer une réservation
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(['message' => 'Réservation supprimée']);
    }
}
