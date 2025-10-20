<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Artist;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
  


         $query = Artist::query();

        // Si une recherche est envoyée
    

       
        // $artists = Artist::all(); // récupère toutes les données
        // $artists = Artist::paginate(50); // 50 lignes par page
        // $artists = Artist::paginate(50);
        $artists = $query->paginate(50);
      

        // $artists = Artist::orderBy('pseudo', 'asc')->get(); raha alefa par alphabet
//                   chemin                variable io ambony io   



         // 1. Nombre total d'artistes
    $totalArtists = Artist::count();
        
    // Nombre d’artistes par catégorie
         $artistsByCategory = Artist::select('categorie', DB::raw('count(*) as total'))
        ->groupBy('categorie')
        ->get();
  
        // Liste fixe des catégories
        $categorie = [
             'LYR',
            'LIT',
            'DRA',
            'AAV'
        ];

       
    

        $recentArtists = Artist::orderBy('date_adh','desc')->take(5)->get();
        $sort = $request->get('sort', 'nom'); // champ de tri par défaut
        $order = $request->get('order', 'desc');    // ordre par défaut

        $artists = Artist::orderBy($sort, $order)
        ->paginate(10)
        ->appends(request()->query()); // <-- ajoute les paramètres dans la pagination

         return view('artists.index', compact('totalArtists','artists', 'categorie', 'recentArtists', 'sort', 'order', 'artistsByCategory'));
    }

public function byCategory(Request $request, $categorie)
{
    $query = Artist::where('categorie', $categorie);

    // Recherche
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nom', 'LIKE', "%{$search}%")
              ->orWhere('pseudo', 'LIKE', "{$search}%")
              ->orWhere('num', 'LIKE', "{$search}%")
              ->orWhere('contact', 'LIKE', "{$search}%");
        });
    }

    // Tri
    $sort = $request->get('sort', 'num');  // par défaut trier par num
    $order = $request->get('order', 'asc'); // par défaut asc
    $query->orderBy($sort, $order);

    // Pagination (avec conservation des paramètres)
    $artists = $query->paginate(25)->appends($request->query());
    $artists->onEachSide(0); // n'affiche que les positions des pages à proximité



    return view('artists.byCategory', compact('artists', 'categorie', 'sort', 'order'));
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
if (!session()->has('admin_id')) {
            return redirect('/login');
        }

    ActivityLog::create([
        'user_id' => session('admin_id'),
        'action' => 'a ajouté',
        'model_type' => 'l\'artiste',
        'details' => $request->nom,
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

          if (!session()->has('admin_id')) {
            return redirect('/login');
        }

        ActivityLog::create([
    'user_id' => session('admin_id'),
    'action' => 'a modifié',
    'model_type' => 'l\' artiste',
    'details' => $request->nom,
]);

  


        return redirect()->route('artists.byCategory', $artist->categorie)->with('success', 'Artiste modifié avec succès');
    }
        public function destroy($num)
    {
        $artist = Artist::findOrFail($num);

         if (!session()->has('admin_id')) {
            return redirect('/login');
        }

        ActivityLog::create([
    'user_id' => session('admin_id'),
    'action' => 'a supprimé',
    'model_type' => 'l\'artiste',
    'details' => $artist->nom,
]);

        $artist->delete();

       


        return redirect()->route('artists.index')->with('success', 'Artiste supprimé avec succès');
    }

    // public function show($num)
    // {
    //     $artist = Artist::findOrFail($num);
    //    return view('artists.show', compact('artist'));
    // }

//     public function show($num)
// {
//     $artist = Artist::where('num', $num)->firstOrFail();

//     if ($artist->categorie === 'LYR') {
//         $oeuvres = $artist->oeuvresMusique;
//         $type = 'musique';
//     } else {
//         $oeuvres = $artist->oeuvresNonMusique;
//         $type = 'non_musique';
//     }

//     return view('artists.show', compact('artist', 'oeuvres', 'type'));
// }


public function show($num)
{
    $artist = Artist::where('num', $num)->firstOrFail();

    // Récupérer toutes les œuvres possibles, peu importe la table
    $oeuvresMusique = $artist->oeuvresMusique;
    
    $oeuvresNonMusique = $artist->oeuvresNonMusique;
    if($oeuvresMusique ){
         $type = 'musique';
    }
    else{
          $type = 'non_musique';
    }
    // Fusionner les deux collections
    $oeuvres = $oeuvresMusique->merge($oeuvresNonMusique);

    return view('artists.show', compact('artist', 'oeuvres', 'type'));
}




}
