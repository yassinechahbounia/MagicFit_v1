<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Programme;

// class ProgrammeController extends Controller
// {
//     public function index()
//     {
//         $programmes = Programme::with('exercices')->get();
//         return response()->json($programmes);
//     }

//     public function showAll()
//     {
//         return response()->json(Programme::with('exercices')->get());
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'nom' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'categorie' => 'required|string',
//             'image' => 'nullable|string',
//             'exercices' => 'nullable|array',
//         ]);

//         $programme = Programme::create($request->only(['nom', 'description', 'categorie', 'image']));

//         if ($request->has('exercices')) {
//             $programme->exercices()->sync($request->input('exercices'));
//         }

//         return response()->json($programme->load('exercices'), 201);
//     }

//     public function show($id)
//     {
//         $programme = Programme::with('exercices')->find($id);

//         if (!$programme) {
//             return response()->json(['message' => 'Programme non trouvé'], 404);
//         }

//         return response()->json($programme);
//     }

//     public function update(Request $request, $id)
//     {
//         $programme = Programme::findOrFail($id);
//         $programme->update($request->only(['nom', 'description', 'categorie', 'image']));

//         if ($request->has('exercices')) {
//             $programme->exercices()->sync($request->input('exercices'));
//         }

//         return response()->json($programme->load('exercices'));
//     }

//     public function destroy($id)
//     {
//         $programme = Programme::findOrFail($id);
//         $programme->exercices()->detach(); // Nettoyage avant suppression
//         $programme->delete();

//         return response()->json(['message' => 'Programme supprimé']);
//     }
// }

// ******************
namespace App\Http\Controllers;

use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProgrammeController extends Controller
{
    // Liste tous les programmes avec exercices
    public function index()
    {
        return response()->json(Programme::with('exercices')->get());
    }

    // Voir un programme avec ses exercices
    public function show($id)
    {
        $programme = Programme::with('exercices')->find($id);

        if (!$programme) {
            return response()->json(['message' => 'Programme non trouvé'], 404);
        }

        return response()->json($programme);
    }

    // Créer un programme
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'categorie' => 'nullable|string',
            'image' => 'nullable|string',
            'objectif' => 'nullable|string',
            'nutrition' => 'nullable|array',
        ]);

        $programme = Programme::create($request->all());

        return response()->json($programme, 201);
    }
    

    // Modifier un programme
    public function update(Request $request, $id)
    {
        $programme = Programme::findOrFail($id);
        $programme->update($request->all());

        return response()->json($programme);
    }

    // Supprimer un programme
    public function destroy($id)
    {
        $programme = Programme::findOrFail($id);
        $programme->delete();

        return response()->json(['message' => 'Programme supprimé']);
    }
}
 
