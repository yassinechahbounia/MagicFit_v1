<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suivi;
use App\Models\User;

class SuiviController extends Controller
{
    // 🔍 Liste des suivis avec les infos utilisateur
    public function index()
    {
        return response()->json(Suivi::with('user')->get());
    }

    // ➕ Ajouter un suivi (par email ou nom utilisateur)
   public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'date' => 'required|date',
        'poids' => 'nullable|numeric',
        'repetitions' => 'required|numeric',
        'commentaire' => 'nullable|string'
    ]);

    // Trouver l'utilisateur par nom ou email*************
    // $user = User::where('name', $validated['utilisateur'])
    //             ->orWhere('email', $validated['utilisateur'])
    //             ->first();
    

    if (!$user) {
        return response()->json(['message' => 'Utilisateur introuvable'], 404);
    }

    $suivi = Suivi::create([
        'user_id' => $validated['user_id'],
        'date' => $validated['date'],
        'poids' => $validated['poids'],
        'repetitions' => $validated['repetitions'],
        'commentaire' => $validated['commentaire']
    ]);

    return response()->json(['message' => 'Suivi ajouté', 'suivi' => $suivi]);
}

    // ❌ Supprimer un suivi
    public function destroy($id)
    {
        $suivi = Suivi::find($id);
        if (!$suivi) {
            return response()->json(['message' => 'Suivi non trouvé'], 404);
        }

        $suivi->delete();
        return response()->json(['message' => 'Suivi supprimé']);
    }
}
