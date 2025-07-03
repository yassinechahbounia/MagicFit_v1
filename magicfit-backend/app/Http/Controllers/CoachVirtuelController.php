<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CoachVirtuelController extends Controller
{
    public function handle(Request $request)
    {
        // 🔧 Forcer Laravel à interpréter correctement les tableaux JSON
        $data = $request->json()->all();

        // ✅ Validation explicite
        $validator = validator($data, [
            'question' => 'required|string',
            'historique' => 'required|array|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        // 🔐 API Key stockée dans .env
        $apiKey = env('OPENROUTER_API_KEY');

        // 🧠 Appel OpenRouter
        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type' => 'application/json',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'openai/gpt-3.5-turbo',
            'messages' => array_merge(
                [['role' => 'system', 'content' => 'Tu es un coach virtuel expert en musculation et nutrition.']],
                $validated['historique'],
                [['role' => 'user', 'content' => $validated['question']]]
            )
        ]);

        if (!$response->successful()) {
            return response()->json([
                'error' => 'Erreur API OpenRouter',
                'details' => $response->json(),
            ], $response->status());
        }

        $result = $response->json();

        return response()->json([
            'reponse' => $result['choices'][0]['message']['content'] ?? 'Pas de réponse reçue',
        ]);
    }
}
