<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
         $query = Artist::query();

        // Si une recherche est envoyée
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nom', 'LIKE', "%{$search}%")
              ->orWhere('groupes', 'LIKE', "%{$search}%")
              ->orWhere('pseudo', 'LIKE', "%{$search}%")
              ->orWhere('num', 'LIKE', "%{$search}%")
              ->orWhere('contact', 'LIKE', "%{$search}%")
              ->orWhere('date_adh', 'LIKE', "%{$search}%");
        });
    }

       
        // $artists = Artist::all(); // récupère toutes les données
        // $artists = Artist::paginate(50); // 50 lignes par page
        // $artists = Artist::paginate(50);
         $artists = $query->paginate(50);
        // $artists = Artist::orderBy('pseudo', 'asc')->get(); raha alefa par alphabet
        return view('artists.index', compact('artists'));
//                   chemin                variable io ambony io   
        



    }




public function store(Request $request)
{
    // // On ne prend que les champs essentiels pour éviter les erreurs MySQL
    // $data = $request->only([
    //     'nom', 'pseudo', 'date_naissance', 'num_wipo', 'categorie'
    // ]);

    // Ajout d’un artiste
    $artist = Artist::create([
    'num_wipo' => $request->num_wipo,
    'date_adh' => $request->date_adh,   // <-- obligatoire
    'num' => $request->num,
    'categorie' => $request->categorie,
    'nom' => $request->nom,
    'pseudo' => $request->pseudo,
    'groupes' => $request->groupes,
    'contact' => $request->contact,
    'email' => $request->email,
    'adresse' => $request->adresse,
    'province' => $request->province,
    'sexe' => $request->sexe,
    'cin' => $request->cin,
    'date_naissance' => $request->date_naissance,
    'pension' => $request->pension,
    'statut' => $request->statut,
    'hologramme' => $request->hologramme,
]);


    // Vérifie si l’insertion a réussi
    if ($artist) {
        return redirect()->route('artists.index')
            ->with('success', 'Artiste ajouté avec succès !');
    } else {
        return redirect()->route('artists.index')
            ->with('error', 'Impossible d’ajouter l’artiste.');
    }
}



    public function edit($num)
    {
        $artist = Artist::findOrFail($num);
        return view('artists.edit', compact('artist'));
    }
    public function update(Request $request, $num)
    {
        $artist = Artist::findOrFail($num);

        $artist->update($request->all()); // met à jour tous les champs

        return redirect()->route('artists.index')->with('success', 'Artiste modifié avec succès');
    }
        public function destroy($num)
    {
        $artist = Artist::findOrFail($num);
        $artist->delete();

        return redirect()->route('artists.index')->with('success', 'Artiste supprimé avec succès');
    }

    public function search(Request $request)
{
    $query = $request->input('q');

    $artists = Artist::where('nom', 'like', "%$query%")
                    ->orWhere('pseudo', 'like', "%$query%")
                    ->orWhere('groupes', 'LIKE', "%{$search}%")
                    ->orWhere('num', 'LIKE', "%{$search}%")
                    ->orWhere('categorie', 'like', "%$query%")
                    ->orWhere('contact', 'like', "%$query%")
                    ->get();

    return response()->json($artists);
}


}
