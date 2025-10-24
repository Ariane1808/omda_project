<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Artist;
use App\Models\OeuvreMusique;
use App\Models\OeuvreNonMusique;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Throwable;

class OeuvreController extends Controller
{
    public function index()
    {
        $musiques = OeuvreMusique::all();
        $nonMusiques = OeuvreNonMusique::all();

        // Récupère quelques-unes des plus récentes de chaque table, fusionne et trie
        $recentMusiques = OeuvreMusique::orderBy('date_depot', 'desc')->take(5)->get()->map(function($m) {
            $arr = $m->toArray();
            // s'assurer que la clé 'categorie' existe (déjà présente pour musique)
            $arr['categorie'] = $arr['categorie'] ?? 'LYR';
            return (object) $arr;
        });

        $recentNon = OeuvreNonMusique::orderBy('date_depot', 'desc')->take(5)->get()->map(function($n) {
            $arr = $n->toArray();
            // Normaliser le champ 'categories' en 'categorie' pour l'affichage
            $arr['categorie'] = $arr['categories'] ?? null;
            return (object) $arr;
        });

        $combined = $recentMusiques->concat($recentNon)->sortByDesc(function($item) {
            return $item->date_depot ?? null;
        })->values();

        $recentOeuvres = $combined->take(5);

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
    $fields = ['nom', 'titre','num', 'code_titre', 'pseudo'];
} else {
    $query = OeuvreNonMusique::where('categories', $categorie);
    $fields = ['titre', 'code_titre','num', 'auteur'];
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

    /**
     * Exporter les oeuvres d'une catégorie en CSV.
     * - si $categorie == 'LYR' exporte les OeuvreMusique
     * - sinon exporte les OeuvreNonMusique
     */
    public function export(Request $request, $categorie)
    {
        if ($categorie === 'LYR') {
            $items = OeuvreMusique::where('categorie', $categorie)->get();
            $headers = ['date_depot', 'code_titre', 'titre', 'categorie', 'num', 'nom', 'pseudo', 'groupes', 'qualite', 'droit', 'part', 'hologramme'];
            $filename = "oeuvres_musiques_{$categorie}.csv";
        } else {
            $items = OeuvreNonMusique::where('categories', $categorie)->get();
            $headers = ['code_titre', 'date_depot', 'num', 'titre', 'categories', 'auteur', 'part'];
            $filename = "oeuvres_non_musiques_{$categorie}.csv";
        }

        $callback = function() use ($items, $headers) {
            $out = fopen('php://output', 'w');
            // En-têtes CSV
            fputcsv($out, $headers);

            foreach ($items as $item) {
                $row = [];
                foreach ($headers as $h) {
                    $row[] = isset($item[$h]) ? $item[$h] : (isset($item->$h) ? $item->$h : '');
                }
                fputcsv($out, $row);
            }
            fclose($out);
        };

        $responseHeaders = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream($callback, 200, $responseHeaders);
    }

    /**
     * Importer un fichier CSV ou XLSX contenant des oeuvres.
     * Attendu : colonnes adaptées (pour musique : categorie='LYR' ; pour non musique : categories in LIT/DRA/AAV)
     */
    public function import(Request $request)
    {
        if (!session()->has('admin_id')) {
            return redirect('/login');
        }

        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls'
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $rows = [];

        // Try using maatwebsite/excel if it's installed; otherwise fallback to native CSV parsing
        if (class_exists('\Maatwebsite\Excel\Facades\Excel')) {
            try {
                $collection = \Maatwebsite\Excel\Facades\Excel::toCollection(new \ArrayObject, $file);
                if ($collection->count() > 0) {
                    $sheet = $collection->first();
                    foreach ($sheet as $row) {
                        $rows[] = $row->toArray();
                    }
                }
            } catch (Throwable $e) {
                // if any error occurs while using the package, fallback to CSV parsing below
            }
        }

        // If rows still empty, try native CSV parsing as a fallback
        if (count($rows) === 0) {
            if (($handle = fopen($path, 'r')) !== false) {
                $header = null;
                while (($data = fgetcsv($handle, 0, ',')) !== false) {
                    if (!$header) {
                        $header = $data;
                        continue;
                    }
                    $rows[] = array_combine($header, $data);
                }
                fclose($handle);
            } else {
                return back()->with('error', 'Impossible de lire le fichier importé.');
            }
        }

        if (count($rows) === 0) {
            return back()->with('error', 'Aucune ligne trouvée dans le fichier.');
        }

        $created = 0;
        foreach ($rows as $r) {
            // Normalize keys to lower case
            $row = array_change_key_case((array)$r, CASE_LOWER);

            // Decide if music or non-music
            $isMusic = false;
            if (isset($row['categorie']) && strtoupper(trim($row['categorie'])) === 'LYR') {
                $isMusic = true;
            }
            // Some files may use 'categories' for non-music
            if ($isMusic) {
                // Map expected fields for OeuvreMusique
                $data = [
                    'date_depot' => $row['date_depot'] ?? null,
                    'code_titre' => $row['code_titre'] ?? ($row['code'] ?? Str::random(8)),
                    'titre' => $row['titre'] ?? null,
                    'categorie' => 'LYR',
                    'num' => $row['num'] ?? null,
                    'nom' => $row['nom'] ?? null,
                    'pseudo' => $row['pseudo'] ?? null,
                    'groupes' => $row['groupes'] ?? null,
                    'qualite' => $row['qualite'] ?? null,
                    'droit' => $row['droit'] ?? null,
                    'part' => $row['part'] ?? null,
                    'hologramme' => $row['hologramme'] ?? null,
                ];

                // Prevent creating duplicates if code_titre exists
                if (!OeuvreMusique::where('code_titre', $data['code_titre'])->exists()) {
                    OeuvreMusique::create($data);
                    $created++;
                }
            } else {
                // Non music
                $data = [
                    'code_titre' => $row['code_titre'] ?? ($row['code'] ?? Str::random(8)),
                    'date_depot' => $row['date_depot'] ?? null,
                    'num' => $row['num'] ?? null,
                    'titre' => $row['titre'] ?? null,
                    'categories' => $row['categories'] ?? ($row['categorie'] ?? null),
                    'auteur' => $row['auteur'] ?? null,
                    'part' => $row['part'] ?? null,
                ];

                if (!OeuvreNonMusique::where('code_titre', $data['code_titre'])->exists()) {
                    OeuvreNonMusique::create($data);
                    $created++;
                }
            }
        }

        ActivityLog::create([
            'user_id' => session('admin_id'),
            'action' => 'a importé',
            'model_type' => "oeuvres",
            'details' => "Import de $created oeuvres via fichier",
        ]);

        return back()->with('success', "Import terminé : $created oeuvres créées.");
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
