<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\work;

class WorkController extends Controller
{
    public function index()
    {
        $work = work::all(); // récupérer tous les artistes
        return view('works.index', compact('work'));
//                   chemin                variable io ambony io                               
    }
}
