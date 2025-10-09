<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Artist;
use App\Models\OeuvresMusique;
use App\Models\OeuvresNonMusique;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class AuthController extends Controller
{
    // Afficher le formulaire de login
    public function showLogin()
    {
        return view('login');
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $admin = Admin::where('username', $request->username)->first();

        // Vérifier mot de passe
        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin_id' => $admin->id, 'username' => $admin->username]);
            return redirect('/dashboard');
        }

        return back()->withErrors(['username' => 'Identifiant ou mot de passe incorrect']);
    }

    // Afficher le dashboard
    public function dashboard()
    {
        if (!session()->has('admin_id')) {
            return redirect('/login');
        }
        $totalArtists = Artist::count();
        
    // 2. Nombre d’artistes par catégorie
    $artistsByCategory = Artist::select('categorie', DB::raw('count(*) as total'))
        ->groupBy('categorie')
        ->get();

    // total oeuvres
    $totalOeuvres = DB::table('oeuvres_musiques')->count() + DB::table('oeuvres_non_musiques')->count();

    // comptage des oeuvres
     $oeuvresMusique = \App\Models\OeuvreMusique::count();
    $oeuvresNonMusique = \App\Models\OeuvreNonMusique::select('categories', \DB::raw('COUNT(*) as total'))
        ->groupBy('categories')
        ->get();


    // Transformer les catégories non-musique
    $oeuvresByCategory = collect([
        (object)['categories' => 'Oeuvres Musicales', 'total' => $oeuvresMusique],
    ])->merge(
        $oeuvresNonMusique->map(function ($item) {
            switch ($item->categories) {
                case 'DRA': $item->categories = 'Oeuvres Dramatiques'; break;
                case 'LIT': $item->categories= 'Oeuvres Littéraires'; break;
                case 'AAV': $item->categories = 'Oeuvres Audiovisuelles'; break;
            }
            return $item;
        })
    );
    // compte les artites de cette année
     $currentYear = Carbon::now()->year;
    $artistsThisYear = \App\Models\Artist::whereYear('date_adh', $currentYear)->count();
    
     // Œuvres déposées cette année
    $oeuvresThisYear = \App\Models\OeuvreMusique::whereYear('date_depot', $currentYear)->count()+ \App\Models\OeuvreNonMusique::whereYear('date_depot', $currentYear)->count();

    // moyenne oeuvre par artiste
    $moyenneOeuvresParArtiste = $totalArtists > 0 ? round($totalOeuvres / $totalArtists, 2) : 0;


    // Top artiste par nombre d’œuvres
// Compter toutes les oeuvres musicales par artiste
$musiqueCounts = DB::table('oeuvres_musiques')
    ->select('num', DB::raw('COUNT(*) as total'))
    ->groupBy('num')
    ->pluck('total', 'num');  // Retourne [num => total]

// Compter toutes les oeuvres non musicales par artiste
$nonMusiqueCounts = DB::table('oeuvres_non_musiques')
    ->select('num', DB::raw('COUNT(*) as total'))
    ->groupBy('num')
    ->pluck('total', 'num');  // Retourne [num => total]

// Récupérer tous les artistes
$artists = Artist::all()->map(function($artist) use ($musiqueCounts, $nonMusiqueCounts) {
    $artist->total_oeuvres = ($musiqueCounts[$artist->num] ?? 0) + ($nonMusiqueCounts[$artist->num] ?? 0);
    return $artist;
});

// Top artiste
$topArtist = $artists->sortByDesc('total_oeuvres')->first();


 $currentYear = Carbon::now()->year;

    // Adhésions d’artistes par mois (cette année)
    $adhesionsByMonth = \App\Models\Artist::select(
            DB::raw('MONTH(date_adh) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('date_adh', $currentYear)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month')
        ->toArray();

    // Remplir les mois vides par 0
    $months = [];
    for ($i = 1; $i <= 12; $i++) {
        $months[$i] = $adhesionsByMonth[$i] ?? 0;
    }


    
// Œuvres par mois (musicales + non musicales)
$oeuvresByMonth = DB::table('oeuvres_musiques')
    ->select(DB::raw('MONTH(date_depot) as month'), DB::raw('COUNT(*) as total'))
    ->whereYear('date_depot', $currentYear)
    ->groupBy('month')
    ->pluck('total', 'month')
    ->toArray();

$oeuvresByMonthNon = DB::table('oeuvres_non_musiques')
    ->select(DB::raw('MONTH(date_depot) as month'), DB::raw('COUNT(*) as total'))
    ->whereYear('date_depot', $currentYear)
    ->groupBy('month')
    ->pluck('total', 'month')
    ->toArray();

// Fusionner les deux
$mergedOeuvres = [];
for ($i = 1; $i <= 12; $i++) {
    $mergedOeuvres[$i] = ($oeuvresByMonth[$i] ?? 0) + ($oeuvresByMonthNon[$i] ?? 0);
}

        return view('dashboard', compact('totalArtists','artistsByCategory','totalOeuvres','oeuvresByCategory','artistsThisYear','oeuvresThisYear','moyenneOeuvresParArtiste','topArtist','adhesionsByMonth','mergedOeuvres'))->with('username', session('username'));

    }

    // Déconnexion
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
    public function index()
    {    
         if (!session()->has('admin_id')) {
            return redirect('/login');
        }
        // Récupérer tous les utilisateurs ayant le rôle "admin"
        $admins = Admin::all(); // Ajuste selon ton modèle
         return view('admin.index', compact('admins'))->with('username', session('username'));
    }
    public function create()
    {
    return view('admin.create'); // formulaire d'ajout
    }

    public function store(Request $request)
    {
    $request->validate([
        'username' => 'required|unique:admin,username',
        'password' => 'required|min:6',
    ]);

    \App\Models\Admin::create([
        'username' => $request->username,
        'password' => bcrypt($request->password), // hash du mot de passe
    ]);

    return redirect()->route('admin.index')->with('success', 'Administrateur ajouté avec succès.');
    }

     public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        if (!session()->has('admin_id')) {
            return redirect('/login');
        }
        //$admin->edit($request->all()); // met à jour tous les champs

        return view('admin.edit', compact('admin'))->with('username', session('username'));
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'username' => 'required',
        'password' => 'nullable|min:6', // nullable = pas obligé de modifier le mot de passe
    ]);

    $admin = Admin::findOrFail($id);

    $data = ['username' => $request->username];

    // Si un mot de passe est fourni, on le hash
    if (!empty($request->password)) {
        $data['password'] = bcrypt($request->password);
    }

    $admin->update($data);

    return redirect()->route('admin.index')->with('success', 'Admin modifié avec succès.');
    }

          public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.index')->with('success', 'Admin supprimé avec succès');
    }


    public function gestion()
    {
        if (!session()->has('admin_id')) {
            return redirect('/login');
        }
        $admins = Admin::all(); // Ajuste selon ton modèle
        return view('admin.gestion', compact('admins'))->with('username', session('username'));
    }
    public function information()
    {
         if (!session()->has('admin_id')) {
            return redirect('/login');
        }
        $admins = Admin::all(); // Ajuste selon ton modèle
        return view('admin.information', compact('admins'))->with('username', session('username'));
    }
}
