<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CoachVirtuelController extends Controller
{
    public function handle(Request $request)
{
    $validated = $request->validate([
        'question' => 'required|string',
        'historique' => 'nullable|array',
    ]);

    $messages = [];

    // Ajouter un message système initial
    $messages[] = ['role' => 'system', 'content' => 'Tu es un coach expert en musculation et nutrition. Tu poses des questions avant de répondre, tu motives, corriges et suis les progrès.'];

    // Ajouter l’historique s’il existe
    if (!empty($validated['historique'])) {
        foreach ($validated['historique'] as $msg) {
            $messages[] = [
                'role' => $msg['role'] ?? 'user',
                'content' => $msg['content'] ?? ''
            ];
        }
    }

    // Ajouter la nouvelle question
    $messages[] = ['role' => 'user', 'content' => $validated['question']];

    $response = Http::timeout(60)
        ->withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
            'Content-Type' => 'application/json',
        ])
        ->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'deepseek/deepseek-r1:free',
            'messages' => $messages
        ]);

    if (!$response->successful()) {
        return response()->json([
            'error' => 'Erreur API OpenRouter',
            'details' => $response->json(),
        ], $response->status());
    }

    $data = $response->json();

    if (!isset($data['choices'][0]['message']['content'])) {
        return response()->json([
            'error' => 'Réponse invalide de l’API',
            'raw' => $data,
        ], 500);
    }

    return response()->json([
        'reponse' => $data['choices'][0]['message']['content']
    ]);
}
}