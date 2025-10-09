<?php

use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login'); // On affiche la vue login par défaut
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/dashboard', [AuthController::class, 'dashboard']);
Route::get('/logout', [AuthController::class, 'logout']);

use App\Http\Controllers\ArtistController;
Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index'); // liste des artistes 
Route::get('/artists/create', [ArtistController::class, 'create']); // formulaire ajout 
Route::post('/artists', [ArtistController::class, 'store'])->name('artists.store'); // sauvegarde nouvel artiste 
Route::get('/artists/{num}/edit', [ArtistController::class, 'edit'])->name('artists.edit'); // modifier un artiste 
Route::put('/artists/{num}', [ArtistController::class, 'update'])->name('artists.update'); // sauvegarder modif 
Route::delete('/artists/{num}', [ArtistController::class, 'destroy'])->name('artists.destroy'); // supprimer


use App\Http\Controllers\WorkController;

Route::get('/works', [WorkController::class, 'index']); // liste des artistes
Route::get('/works/create', [WorkController::class, 'create']); // formulaire ajout
Route::post('/works', [WorkController::class, 'store']); // sauvegarde nouvel artiste
Route::get('/works/{id}/edit', [WorkController::class, 'edit']); // modifier un artiste
Route::put('/works/{id}', [WorkController::class, 'update']); // sauvegarder modif
Route::delete('/works/{id}', [WorkController::class, 'destroy']); // supprimer


use App\Http\Controllers\OeuvreController;

Route::get('/artists/{id}/oeuvres', [OeuvreController::class, 'index'])->name('artists.oeuvres');
