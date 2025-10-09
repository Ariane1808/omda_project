<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\OeuvreMusique;

class OeuvreMusiqueController extends Controller
{
    // Formulaire de création
    public function create($artistNum)
    {
        // On récupère l'artiste concerné
        $artist = Artist::where('num', $num)->firstOrFail();
        return view('oeuvres.musique.create', compact('artist'));
    }

    // Enregistrement
    public function store(Request $request)
    {
        $request->validate([
            'date_depot' => 'required|date',
            'code_titre' => 'required|exists:num',
            'titre'      => 'required|string|max:255',
            'categorie'  => 'required|string|max:255',
            'num'        => 'required|exists:num',
            'nom'  => 'required|string|max:255',
            'pseudo'  => 'required|string|max:255',
            'groupe'  => 'required|string|max:255',
            'qualite'  => 'required|string|max:255',
            'droit'  => 'required|string|max:255',
             'part'  => 'required|string|max:255',
            'hologramme'      => 'nullable|string|max:255',
        ]);

        OeuvreMusique::create([
            'num'   => $request->artist_num,  // clé étrangère vers artistes.num
            'titre' => $request->titre,
            'genre' => $request->genre,
        ]);

        return redirect()->route('artists.show', $request->artist_num)
                         ->with('success', 'Œuvre musicale ajoutée avec succès !');
    }
}
