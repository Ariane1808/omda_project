<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\work;

class WorkController extends Controller
{
      public function index(Request $request)
    {
  


         $query = work::query();

        // Si une recherche est envoyée
    

       
        // $artists = Artist::all(); // récupère toutes les données
        // $artists = Artist::paginate(50); // 50 lignes par page
        // $artists = Artist::paginate(50);
            //  chemin                variable io ambony io   
        
  
        // Liste fixe des catégories
        $categorie = [
            'LIT',
            'DRA',
            'AAV'
        ];

        return view('oeuvres.index', compact('oeuvres_non_musiques', 'categorie'));
    


    }
}
