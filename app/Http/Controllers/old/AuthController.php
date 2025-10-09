<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

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

        return view('dashboard', ['username' => session('username')]);
    }

    // Déconnexion
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}
