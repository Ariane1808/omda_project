<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Artist;
use App\Models\OeuvreMusique;
use App\Models\OeuvreNonMusique;
use App\Models\ActivityLog;

class OeuvreController extends Controller
{
    public function index()
    {
        $musiques = OeuvreMusique::all();
        $nonMusiques = OeuvreNonMusique::all();
        $recentOeuvres = OeuvreMusique::orderBy('date_depot','desc')->take(5)->get();
        if (!$recentOeuvres) {
            $recentOeuvres = OeuvreNonMusique::orderBy('date_depot','desc')->take(5)->get();
        }
        return view('oeuvres.index', compact('musiques', 'nonMusiques', 'recentOeuvres'));
    }


  public function create(Request $request)
{
    $type = $request->query('type');
    $num  = $request->query('num');

    $artist = Artist::where('num', $num)->firstOrFail();

    return view('oeuvres.create', compact('artist', 'type'));
}


    public function store(Request $request)
    {
        if ($request->type === 'musique') {
            OeuvreMusique::create([
                'date_depot' => $request->date_depot,
                'code_titre' => $request->code_titre,
                'titre' => $request->titre,
                'categorie' => 'LYR',
                'num' => $request->num,
                'nom' => $request->nom, 
                'pseudo' => $request->pseudo,
                'groupes' => $request->groupes,
                'qualite' => $request->qualite,
                'droit' => $request->droit,
                'part' => $request->part,
                'hologramme' => $request->hologramme
            ]);
        } else {
            OeuvreNonMusique::create([
                'code_titre' => $request->code_titre,
                'date_depot' => $request->date_depot,
                'num' => $request->num,
                'titre' => $request->titre,
                'categories' => $request->categories, // LIT, DRAM ou AAV
                'auteur' => $request->auteur,
                'part' => $request->part
            ]);
        }
      
         if (!session()->has('admin_id')) {
            return redirect('/login');
        }


// Exemple après un ajout d'œuvre
ActivityLog::create([
    'user_id' => session('admin_id'),
    'action' => 'a ajouté',
    'model_type' => 'l\'oeuvre',
    'details' => $request->titre . ' pour l\'artiste numéro ' . $request->num,
]);


        return redirect()->route('oeuvres.index')->with('success', 'Œuvre ajoutée avec succès.');
    }
    // public function byCategory(Request $request, $categorie)
    
    // {
    //      if ($categorie == 'LYR') {
    //         // œuvres musicales
    //        $query = OeuvreMusique::where('categorie', $categorie);
    //     } else {
    //         // œuvres non musicales
    //         $query = OeuvreNonMusique::where('categories', $categorie);
    //     }

    //      // Recherche
    // if ($request->has('search') && !empty($request->search)) {
    //     $search = $request->search;
    //     $query->where(function($q) use ($search) {
    //         $q->where('nom', 'LIKE', "%{$search}%")
    //           ->orWhere('titre', 'LIKE', "{$search}%")
    //           ->orWhere('code_titre', 'LIKE', "{$search}%")
    //           ->orWhere('pseudo', 'LIKE', "{$search}%");
    //     });
    // }

    //     if ($categorie == 'LYR') {
    //         // œuvres musicales
    //         $oeuvres = OeuvreMusique::where('categorie', $categorie)->paginate(25);
    //           $oeuvres->onEachSide(0); // n'affiche que les positions des pages à proximité
    //     } else {
    //         // œuvres non musicales
    //         $oeuvres = OeuvreNonMusique::where('categories', $categorie)->paginate(25);
    //           $oeuvres->onEachSide(0); // n'affiche que les positions des pages à proximité
    //     }

    //     return view('oeuvres.list', compact('oeuvres', 'categorie'));
    // }

public function byCategory(Request $request, $categorie)
{
    // Déterminer le modèle selon la catégorie
  if ($categorie == 'LYR') {
    $query = OeuvreMusique::where('categorie', $categorie);
    $fields = ['nom', 'titre', 'code_titre', 'pseudo'];
} else {
    $query = OeuvreNonMusique::where('categories', $categorie);
    $fields = ['titre', 'code_titre', 'auteur'];
}

if ($request->filled('search')) {
    $search = $request->search;
    $query->where(function($q) use ($fields, $search) {
        foreach ($fields as $field) {
            $q->orWhere($field, 'LIKE', "%{$search}%");
        }
    });
}


    // ✅ Utiliser la même requête pour la pagination
    $oeuvres = $query->paginate(25)->appends($request->query());
    $oeuvres->onEachSide(0);

    return view('oeuvres.list', compact('oeuvres', 'categorie'));
}

    public function show($num)
    {
        $oeuvre = OeuvreMusique::where('num', $num)->firstOrFail();
        if ($oeuvre->categorie === 'LYR') {
            $artist = $oeuvre->artist;
            // $artist = $oeuvres->oeuvresMusique;
            $type = 'musique';
        } else {
            $artist = $oeuvre->artist;
            // $oeuvres = $artis->oeuvresNonMusique;
            $type = 'non_musique';
        }
        
        compact('type','oeuvre');
        return view('artists.show', compact('artist', 'oeuvres', 'type')); 
    }
    public function edit($code_titre)
    {
        $oeuvre = OeuvreMusique::where('code_titre', $code_titre)->first();
        if (!$oeuvre) {
            $oeuvre = OeuvreNonMusique::findOrFail($code_titre);
        }
        return view('oeuvres.edit', compact('oeuvre'));
    }
    public function update(Request $request, $code_titre) {
        $oeuvre = OeuvreMusique::where('code_titre', $code_titre)->first();
        if (!$oeuvre) {
            $oeuvre = OeuvreNonMusique::findOrFail($code_titre);
        }
        $oeuvre->update($request->all());
        
         if (!session()->has('admin_id')) {
            return redirect('/login');
        }

// Exemple après un ajout d'œuvre
ActivityLog::create([
    'user_id' => session('admin_id'),
    'action' => 'a modifié',
    'model_type' => 'l\'oeuvre',
    'details' => $request->titre . ' de l\'artiste numéro ' . $oeuvre->num,
]);

        return redirect()->route('oeuvres.index')->with('success', 'Oeuvre modifié avec succès');
    }
    public function destroy($code_titre)
    {
           


        $oeuvre = OeuvreMusique::where('code_titre', $code_titre)->first();
        if (!$oeuvre) {
            $oeuvre = OeuvreNonMusique::findOrFail($code_titre);
        }
         if (!session()->has('admin_id')) {
            return redirect('/login');
        }

    // Exemple après un ajout d'œuvre
    ActivityLog::create([
    'user_id' => session('admin_id'),
    'action' => 'a supprimé',
    'model_type' => 'l\'oeuvre',
    'details' => $oeuvre->titre . ' de l\'artiste numéro ' . $oeuvre->num,
    ]);

        $oeuvre->delete();

     
        return redirect()->route('oeuvres.index')->with('success', 'Oeuvre supprimé avec succès');
    }
}
