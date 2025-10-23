<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Artist;
use App\Models\OeuvresMusique;
use App\Models\OeuvresNonMusique;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;

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
        'password' => 'required',
    ]);

    $admin = Admin::where('username', $request->username)->first();

    if (!$admin || !Hash::check($request->password, $admin->password)) {
        return back()->withErrors(['username' => 'Nom d\'utilisateur ou mot de passe incorrect']);
    }


    // 🔒 Vérifier si une session est déjà active
// // 🔒 Vérifier si une session est déjà active

    // if ($admin->session_id && $admin->session_id !== Session::getId()) {
    //     return back()->withErrors(['username' => 'Compte déjà connecté sur un autre appareil']);
    // }

    // ✅ Connexion autorisée → enregistrer la session
    // session([
    //     'admin_id' => $admin->id,
    //     'username' => $admin->username,
    //     'role' => $admin->role,
    //     'admin' => $admin
    // ]);
    session([
    'admin_id' => $admin->id,
    'username' => $admin->username,
    'role' => $admin->role,
    'admin' => $admin,
]);


    // 🔁 Mettre à jour le session_id
    $admin->update(['session_id' => Session::getId()]);

      ActivityLog::create([
    'user_id' => session('admin_id'),
    'action' => 's\'est connécté',
    'model_type' => 'en tant qu\'admin :',
    'details' => 'Connection de ' . $admin->username,
    ]);

    $admin = Admin::find(session('admin_id'));
if ($admin && $admin->last_activity) {
    if (now()->diffInSeconds($admin->last_activity) > 5) {
        // Supprimer la session expirée
        $admin->update(['session_id' => null]);
        session()->forget('admin_id');
        return redirect('/login')->with('error', 'Session expirée. Veuillez vous reconnecter.');
    }
}


    return redirect('/dashboard');
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
    $moyenneOeuvresParArtiste = $totalArtists > 0 ? round($totalOeuvres / $totalArtists, 0) : 0;


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



    // Récupère les 5 événements les plus récents
    $evenementsRecents = Event::orderBy('created_at', 'desc')->take(3)->get();

    $admins = Admin::all(); // Ajuste selon ton modèle
    $activities = ActivityLog::latest()->take(3)->get(); //  dernière action



        return view('dashboard', compact('totalArtists','artistsByCategory','totalOeuvres','oeuvresByCategory','artistsThisYear','oeuvresThisYear','moyenneOeuvresParArtiste','topArtist','adhesionsByMonth','mergedOeuvres','evenementsRecents','activities'))->with('username', session('username'));

    }

    // Déconnexion
    public function logout()
    {
        $admin = Admin::find(session('admin_id'));

         if ($admin) {
        $admin->update(['session_id' => null]);
    }

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
         $activities = ActivityLog::latest()->take(10)->get(); // 10 dernières actions


        //   $events = Event::all();
        $events = Event::orderBy('start', 'desc')->paginate(3);
         // Format pour Flatpickr
   $formattedEvents = $events->map(function($event) {
    return [
        'id' => $event->id,
        'title' => $event->title,
        'start' => $event->start,
        'end' => $event->end,
        'description' => $event->description,
    ];
});


        foreach ($events as $event) {
            $formattedEvents[] = [
                'id' => $event->id,  
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'description' => $event->description,
            ];
        }

        $eventDates = $events->pluck('start')->map(function($date) {
    return \Carbon\Carbon::parse($date)->format('Y-m-d');
});

         return view('admin.index', compact('admins','activities','events','eventDates','formattedEvents'))->with('username', session('username'));
    }


    public function create()
    {
    return view('admin.create'); // formulaire d'ajout
    }



   public function store(Request $request)
{
   $admin = session('admin');


    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email',
        'adresse' => 'required|string|max:255',
        'telephone' => 'required|string|max:30',
        'password' => 'required|string|min:6',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:8192',
    ]);

    // Upload photo si présente
    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('admin', 'public');
    }

    // Création de l'admin
    Admin::create([
        'username' => $validated['username'],
        'email' => $validated['email'],
        'adresse' => $validated['adresse'],
        'telephone' => $validated['telephone'],
        'password' => bcrypt($validated['password']),
        'photo' => $photoPath, // Sauvegarde du chemin
    ]);


    return redirect()->back()->with('success', 'Administrateur ajouté avec succès.');
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
        'email' => 'required|email',
        'adresse' => 'required|string|max:255',
        'telephone' => 'required|string|max:30',
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


    public function updateInfo(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'adresse' => 'required|string|max:255',
        'telephone' => 'required|string|max:30',
        'current_password' => 'required'
    ]);

    $admin = Admin::find(session('admin_id'));

    if (!Hash::check($request->current_password, $admin->password)) {
        return back()->with('error', 'Mot de passe actuel incorrect.');
    }

    $admin->update([
        'username'  => $request->username,
        'email'     => $request->email,
        'adresse'   => $request->adresse,
        'telephone' => $request->telephone,
    ]);

    session(['username' => $admin->username]);

    return back()->with('success', 'Modification du profil réussie.');
}

    public function updatePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    $admin = Admin::find(session('admin_id'));

    if (!Hash::check($request->old_password, $admin->password)) {
        return back()->with('error', 'Ancien mot de passe incorrect.');
    }

    $admin->password = Hash::make($request->new_password);
    $admin->save();

    return back()->with('success', 'Mot de passe modifié avec succès.');
}

public function deleteAccount(Request $request)
{
    $request->validate(['password' => 'required']);

    $admin = Admin::find(session('admin_id'));

    if (!Hash::check($request->password, $admin->password)) {
        return back()->with('error', 'Mot de passe incorrect.');
    }

    $admin->delete();
    session()->forget('admin_id');

    return redirect('/login')->with('success', 'Compte supprimé avec succès.');
}



    public function gestion()
    {
        if (!session()->has('admin_id')) {
            return redirect('/login');
        }
        $admin = Admin::find(session('admin_id')); // Ajustement selon le modèle
        return view('admin.gestion', compact('admin'))->with('username', session('username'));
    }
    public function information()
    {
         if (!session()->has('admin_id')) {
            return redirect('/login');
        }
        $admin = Admin::find(session('admin_id'));

        if (!$admin) {
        // sécurité : si l'ID de session est invalide on redirige vers login
        session()->forget('admin_id');
        return redirect('/login')->with('error', 'Administrateur introuvable.');
    }

        return view('admin.information', compact('admin'))->with('username', session('username'));
    }

  public function updatePhoto(Request $request)
{
    if (!session()->has('admin_id')) {
        return redirect()->back()->with('error', 'Aucun administrateur connecté.');
    }

    $admin = Admin::find(session('admin_id'));

    if (!$admin) {
        return redirect()->back()->with('error', 'Administrateur introuvable.');
    }

    $request->validate([
        'photo' => 'required|image|mimes:jpg,jpeg,png,gif|max:8192',
    ]);

    // Supprimer l'ancienne photo si elle existe
    if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
        Storage::disk('public')->delete($admin->photo);
    }

    // Upload de la nouvelle photo
    $photoPath = $request->file('photo')->store('admin', 'public');

    // Mise à jour de la photo
    $admin->update(['photo' => $photoPath]);

    // Rafraîchir la session (photo mise à jour)
    session(['admin' => $admin]);

    return redirect()->back()->with('success', 'Photo de profil mise à jour avec succès.');
}



}
