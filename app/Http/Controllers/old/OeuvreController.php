<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class OeuvreController extends Controller
{
    public function index($id)
    {
        // Charger l'artiste avec ses oeuvres (relation Eloquent)
        $artist = Artist::with(['oeuvres' => function($query) {
    $query->orderBy('titre', 'asc'); // asc = ordre croissant
}])->findOrFail($id);


        return view('oeuvres.index', compact('artist'));
    }
}


