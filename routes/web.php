<?php

use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


Route::get('/', function () {
    return view('login'); // On affiche la vue login par défaut
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/dashboard', [AuthController::class, 'dashboard']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/admin', [AuthController::class, 'index'])->name('admin.index');
Route::get('/admin/create', [AuthController::class, 'create'])->name('admin.create');
Route::post('/admin', [AuthController::class, 'store'])->name('admin.store');
Route::get('/admin/gestion', [AuthController::class, 'gestion'])->name('admin.gestion');
Route::post('/admin/deleteAccount', [AuthController::class, 'deleteAccount'])->name('admin.deleteAccount');
Route::get('/admin/information', [AuthController::class, 'information'])->name('admin.information');
Route::get('/admin/{id}/edit', [AuthController::class, 'edit'])->name('admin.edit');
Route::put('/admin/{id}', [AuthController::class, 'update'])->name('admin.update');
Route::delete('/admin/{id}', [AuthController::class, 'destroy'])->name('admin.destroy');
// Route::post('/events', [EventController::class,'store'])->name('events.store');
// Route::put('/events/{id}', [EventController::class,'update'])->name('events.update');
// Route::delete('/events/{id}', [EventController::class,'destroy'])->name('events.destroy');
Route::post('/admin/update-info', [AuthController::class, 'updateInfo'])->name('admin.updateInfo');
Route::post('/admin/update-password', [AuthController::class, 'updatePassword'])->name('admin.updatePassword');
Route::post('/admin/deleteAccount', [AuthController::class, 'deleteAccount'])->name('admin.deleteAccount');

use App\Http\Controllers\ArtistController;
Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index'); // liste des artistes 
Route::get('/artists/create', [ArtistController::class, 'create']); // formulaire ajout 
Route::post('/artists', [ArtistController::class, 'store'])->name('artists.store'); // sauvegarde nouvel artiste 
Route::get('/artists/{num}/edit', [ArtistController::class, 'edit'])->name('artists.edit'); // modifier un artiste 
Route::put('/artists/{num}', [ArtistController::class, 'update'])->name('artists.update'); // sauvegarder modif 
Route::delete('/artists/{num}', [ArtistController::class, 'destroy'])->name('artists.destroy'); // supprimer
Route::get('/artists/search', [ArtistController::class, 'search'])->name('artists.search');
Route::get('/artists/category/{categorie}', [ArtistController::class, 'byCategory'])->name('artists.byCategory');
Route::get('/artists/{num}/show', [ArtistController::class, 'show'])->name('artists.show');



use App\Http\Controllers\WorkController;

Route::get('/works', [WorkController::class, 'index']); // liste des artistes
Route::get('/works/create', [WorkController::class, 'create']); // formulaire ajout
Route::post('/works', [WorkController::class, 'store']); // sauvegarde nouvel artiste
Route::get('/works/{id}/edit', [WorkController::class, 'edit']); // modifier un artiste
Route::put('/works/{id}', [WorkController::class, 'update']); // sauvegarder modif
Route::delete('/works/{id}', [WorkController::class, 'destroy']); // supprimer


use App\Http\Controllers\OeuvreController;

Route::get('/oeuvres', [OeuvreController::class, 'index'])->name('oeuvres.index');
Route::get('/oeuvres/create', [OeuvreController::class, 'create'])->name('oeuvres.create');
Route::post('/oeuvres', [OeuvreController::class, 'store'])->name('oeuvres.store');
// Pour lister toutes les œuvres par catégorie
Route::get('/oeuvres/category/{categorie}', [OeuvreController::class, 'byCategory'])->name('oeuvres.byCategory');
Route::get('/oeuvres/{code_titre}/edit', [OeuvreController::class, 'edit'])->name('oeuvres.edit'); // modifier un artiste
Route::put('/oeuvres/{code_titre}', [OeuvreController::class, 'update'])->name('oeuvres.update');
Route::delete('/oeuvres/{code_titre}', [OeuvreController::class, 'destroy'])->name('oeuvres.destroy'); // supprimer
Route::get('/oeuvres/{num}/artist', [OeuvreController::class, 'show']);


use App\Http\Controllers\OeuvreMusiqueController;
Route::get('/artists/{artist}/oeuvres/musique/create', [OeuvreMusiqueController::class, 'create'])->name('oeuvres.musiques.create');
Route::post('/oeuvres/musique/store', [OeuvreMusiqueController::class, 'store'])->name('oeuvres.musiques.store');

use App\Http\Controllers\OeuvreNonMusiqueController;
Route::get('/artists/{artist}/oeuvres/nonmusique/create', [OeuvreNonMusiqueController::class, 'create'])->name('oeuvres.nonmusiques.create');
Route::post('/oeuvres/nonmusique/store', [OeuvreNonMusiqueController::class, 'store'])->name('oeuvres.nonmusiques.store');

use App\Http\Controllers\EventController;
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::put('/events/{id}', [EventController::class, 'update']);
Route::delete('/events/{id}', [EventController::class, 'destroy']);

use App\Models\Admin;
Route::get('/ping-session', function() {
    $adminId = session('admin_id'); // ou Auth::id() si tu utilises l’auth Laravel
    if (!$adminId) return response()->noContent();

    $admin = \App\Models\Admin::find($adminId);
    if ($admin) {
        $admin->forceFill(['last_activity' => now()])->save();
    }

    return response()->noContent();
});

