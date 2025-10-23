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


    /**
     * Export all artists as a CSV (Excel-compatible) download.
     */
 public function exportAll(Request $request)
{
    if (!session()->has('admin_id')) {
        return redirect('/login');
    }

    $fileName = 'artists_export_' . date('Ymd_His') . '.xls';
    $artists = Artist::all();

    $columns = [
        'num' => 'Numéro OMDA',
        'num_wipo' => 'Numéro WIPO',
        'date_adh' => 'Date d’adhésion',
        'categorie' => 'Catégorie',
        'nom' => 'Nom',
        'pseudo' => 'Pseudo',
        'groupes' => 'Groupes',
        'contact' => 'Contact',
        'email' => 'Email',
        'adresse' => 'Adresse',
        'province' => 'Province',
        'sexe' => 'Sexe',
        'cin' => 'CIN',
        'date_naissance' => 'Date de naissance',
        'pension' => 'Pension',
        'statut' => 'Statut',
        'hologramme' => 'Hologramme'
    ];

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<?mso-application progid="Excel.Sheet"?>' . "\n";
    $xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
        xmlns:o="urn:schemas-microsoft-com:office:office"
        xmlns:x="urn:schemas-microsoft-com:office:excel"
        xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
        xmlns:html="http://www.w3.org/TR/REC-html40">' . "\n";

    $xml .= '<Styles>
        <Style ss:ID="Header">
            <Font ss:Bold="1" ss:Color="#FFFFFF"/>
            <Interior ss:Color="#4F81BD" ss:Pattern="Solid"/>
            <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
        </Style>
        <Style ss:ID="Default">
            <Alignment ss:Vertical="Center"/>
        </Style>
    </Styles>';

    $xml .= '<Worksheet ss:Name="Artistes"><Table>';

    // En-têtes
    $xml .= '<Row>';
    foreach ($columns as $header) {
        $xml .= '<Cell ss:StyleID="Header"><Data ss:Type="String">' . htmlspecialchars($header) . '</Data></Cell>';
    }
    $xml .= '</Row>';

    // Données
    foreach ($artists as $artist) {
        $xml .= '<Row>';
        foreach (array_keys($columns) as $col) {
            if ($col === 'num_omda') {
                $value = 'OMDA-' . str_pad($artist->num ?? '', 4, '0', STR_PAD_LEFT);
            } else {
                $value = $artist->{$col} ?? '';
            }
            $xml .= '<Cell ss:StyleID="Default"><Data ss:Type="String">' . htmlspecialchars($value) . '</Data></Cell>';
        }
        $xml .= '</Row>';
    }

    $xml .= '</Table></Worksheet></Workbook>';

    // Log d'activité
    ActivityLog::create([
        'user_id' => session('admin_id'),
        'action' => 'a exporté',
        'model_type' => 'les artistes',
        'details' => $fileName,
    ]);

    return response($xml)
        ->header('Content-Type', 'application/vnd.ms-excel')
        ->header('Content-Disposition', "attachment; filename=\"{$fileName}\"")
        ->header('Cache-Control', 'max-age=0');
}

public function import(Request $request)
{
    if (!session()->has('admin_id')) {
        return redirect('/login');
    }

    $request->validate([
        'file' => 'required|file|mimes:csv,txt',
    ]);

    $file = $request->file('file');
    $path = $file->getRealPath();

    $rows = array_map('str_getcsv', file($path));
    $header = array_map('trim', $rows[0]); // première ligne = noms de colonnes
    unset($rows[0]); // supprimer la ligne des en-têtes

    foreach ($rows as $row) {
        $data = array_combine($header, $row);

        // Mettre à jour si le num existe, sinon créer
        Artist::updateOrCreate(
            ['num' => $data['num']], // clé unique
            [
                'num_wipo' => $data['num_wipo'] ?? null,
                'date_adh' => $data['date_adh'] ?? null,
                'categorie' => $data['categorie'] ?? null,
                'nom' => $data['nom'] ?? null,
                'pseudo' => $data['pseudo'] ?? null,
                'groupes' => $data['groupes'] ?? null,
                'contact' => $data['contact'] ?? null,
                'email' => $data['email'] ?? null,
                'adresse' => $data['adresse'] ?? null,
                'province' => $data['province'] ?? null,
                'sexe' => $data['sexe'] ?? null,
                'cin' => $data['cin'] ?? null,
                'date_naissance' => $data['date_naissance'] ?? null,
                'pension' => $data['pension'] ?? null,
                'statut' => $data['statut'] ?? null,
                'hologramme' => $data['hologramme'] ?? null,
            ]
        );
    }

    // Log activité
    ActivityLog::create([
        'user_id' => session('admin_id'),
        'action' => 'a importé',
        'model_type' => 'les artistes',
        'details' => $file->getClientOriginalName(),
    ]);

    return redirect()->route('artists.index')->with('success', 'Import terminé avec succès !');
}


}
