<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Formation;
use App\Models\Information;
use App\Models\ProjetEntrepreneurial;
use App\Models\Publication;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query || strlen($query) < 2) {
            return response()->json([
                'formations' => [],
                'informations' => [],
                'projets' => [],
                'publications' => []
            ]);
        }

        $formations = Formation::where('titre', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'titre']);

        $informations = Information::where('titre', 'like', "%{$query}%")
            ->orWhere('contenu', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'titre']);

        $projets = ProjetEntrepreneurial::where('titre', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'titre']);

        $publications = Publication::where('contenu', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'contenu']);

        return response()->json([
            'formations' => $formations,
            'informations' => $informations,
            'projets' => $projets,
            'publications' => $publications
        ]);
    }
}
