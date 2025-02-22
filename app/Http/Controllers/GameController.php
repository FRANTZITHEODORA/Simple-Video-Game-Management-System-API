<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
   public function index(Request $request)
{
    try {
        $query = Game::query()->where('user_id', Auth::id());

        // Φιλτράρισμα ανά genre (αν υπάρχει στο request)
        if ($request->filled('genre')) {
            $query->where('genre', $request->input('genre'));
        }

        // Ταξινόμηση κατά release_date (αν υπάρχει στο request)
        if ($request->filled('sort') && in_array($request->input('sort'), ['asc', 'desc'])) {
            $query->orderBy('release_date', $request->input('sort'));
        }

        return response()->json($query->get());
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Internal Server Error',
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function store(Request $request)
    {
        // Ελέγχουμε αν ο χρήστης είναι αυθεντικοποιημένος
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'genre' => 'required|string|max:255',
        ]);

        try {
            // Δημιουργούμε το παιχνίδι και το συνδέουμε με τον αυθεντικοποιημένο χρήστη
            $game = Auth::user()->games()->create($validated);

            return response()->json($game, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Game $game)
    {
        return response()->json($game);
    }

    public function update(Request $request, Game $game)
    {
        // Ελέγχουμε αν το παιχνίδι ανήκει στον αυθεντικοποιημένο χρήστη
        if ($game->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $game->update($request->all());
        return response()->json($game);
    }

    public function destroy(Game $game)
    {
        // Ελέγχουμε αν το παιχνίδι ανήκει στον αυθεντικοποιημένο χρήστη
        if ($game->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $game->delete();
        return response()->json(null, 204);
    }
}
