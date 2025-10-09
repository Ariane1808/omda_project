<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\OeuvresMusique;
use App\Models\OeuvresNonMusique;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

public function index()
{
    // 1. Nombre total d'artistes
    $totalArtists = Artist::count();

    // 2. L’artiste avec le plus d’œuvres (fusion des deux tables)
    $topArtist = Artist::withCount([
        'oeuvres_musiques',
        'oeuvres_non_musiques'
    ])
    ->get()
    ->map(function($artist) {
        $artist->total_oeuvres = $artist->oeuvres_musique_count + $artist->oeuvres_non_musique_count;
        return $artist;
    })
    ->sortByDesc('total_oeuvres')
    ->first();

    // 3. Nombre d’artistes par catégorie
    $artistsByCategory = Artist::select('categorie', DB::raw('count(*) as total'))
        ->groupBy('categorie')
        ->get();

    // 4. Nombre d’œuvres par catégorie (fusion des deux tables)
    $worksByCategoryMusique = OeuvresMusique::select('categorie', DB::raw('count(*) as total'))
        ->groupBy('categorie')
        ->get();

    $worksByCategoryNonMusique = OeuvresNonMusique::select('categorie', DB::raw('count(*) as total'))
        ->groupBy('categorie')
        ->get();

    // Fusion des deux résultats
    $worksByCategory = $worksByCategoryMusique->concat($worksByCategoryNonMusique)
        ->groupBy('categorie')
        ->map(function ($items) {
            return $items->sum('total');
        });

    return view('dashboard.index', compact(
        'totalArtists',
        'topArtist',
        'artistsByCategory',
        'worksByCategory'
    ));
}
    
}
