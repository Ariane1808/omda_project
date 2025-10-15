<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification Oeuvre</title>
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">


<style>

/* ----- FORMULAIRE ----- */
.main-conteneur form {
    background: #ffffff;
    border-radius: 12px;
    padding: 25px 30px;
    max-width: 700px;
    margin: auto;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* Champs */
.main-conteneur form div {
    margin-bottom: 12px;
    display: flex;
    flex-direction: column;
}

.main-conteneur form label {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: #1f2937;
}

.main-conteneur form input[type="text"],
.main-conteneur form input[type="date"],
.main-conteneur form select {
    padding: 8px 10px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    font-size: 0.9rem;
    background: #f9fafb;
    transition: border 0.3s, background 0.3s;
}

.main-conteneur form input:focus,
.main-conteneur form select:focus {
    border-color: #2563eb;
    background: #ffffff;
    outline: none;
}

/* Radios */
.main-conteneur form input[type="radio"] {
    margin-right: 5px;
    transform: scale(0.9);
}

.main-conteneur form label[for="homme"],
.main-conteneur form label[for="femme"] {
    font-weight: 500;
    margin-right: 15px;
    display: inline-flex;
    align-items: center;
}

/* ----- BOUTONS STYLE UIVERSE ----- */
.main-conteneur form .btn {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 28px;
    font-weight: 600;
    font-size: 0.95rem;
    border-radius: 10px;
    cursor: pointer;
    border: none;
    text-decoration: none;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.25s ease;
}

/* Effet vague animé Uiverse */
.main-conteneur form .btn::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 200%;
    height: 100%;
    background: rgba(255, 255, 255, 0.15);
    transform: skewX(-20deg);
    transition: left 0.5s ease;
}

.main-conteneur form .btn:hover::before {
    left: 100%;
}

/* Bouton Enregistrer */
.main-conteneur form .btn-save {
    background: #1e3a8a;
    color: #fff;
    box-shadow: 0 4px 10px rgba(30, 58, 138, 0.3);
}

.main-conteneur form .btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(29, 78, 216, 0.4);
}

/* Bouton Annuler */
.main-conteneur form .btn-cancel {
    background: #6b7280;
    color: #fff;
    box-shadow: 0 4px 10px rgba(107, 114, 128, 0.3);
}

.main-conteneur form .btn-cancel:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(75, 85, 99, 0.4);
}

/* ----- RESPONSIVE ----- */
@media (max-width: 768px) {
    .main-conteneur {
        margin-left: 0;
        padding: 20px;
    }

    .main-conteneur form {
        padding: 20px;
        max-width: 100%;
    }
}


</style>
</head>

@include('includes.loader')

<body>




   <nav class="sidebar">
        <div class="logo">
        <h2>Office Malagasy du Droit d'Auteur</h2>
        <h3>O M D A</h3>
        </div>
      <ul class="onglets">
    
            <li><a href="/dashboard"><img src="{{ asset('icons/monitoring_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Dashboard" width="24" height="24" alt=""> Dashboard</a></li>
            <li><a href="/artists" ><img src="{{ asset('icons/artist_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Artistes" width="24" height="24"> Artistes</a></li>
            <li><a href="/oeuvres" class="active"><img src="{{ asset('icons/speech_to_text_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Oeuvres" width="24" height="24">Oeuvres</a></li>
            <li><a href="/admin"  ><img src="{{ asset('icons/admin_panel_settings_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Administration" width="24" height="24">Administration</a></li>
            <li><a href="/logout" class="logout" id="logoutLink"><img src="{{ asset('icons/logout_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Logout" width="24" height="24">Se déconnecter</a></li>

        </ul>
    </nav>




    <div class="main-conteneur">

    @if ($oeuvre->categorie == 'LYR')
    <form action="{{ route('oeuvres.update', $oeuvre->code_titre) }}" method="post">
    @csrf
    @method('PUT')
    <input type="hidden" name="type" value="musique">
    <label for="">Date depôt: </label>
    <input type="date" name="date_depot" value="{{ $oeuvre->date_depot }}"><br><br>
    <label for="">Code titre:</label>
    <input type="text" name="code_titre" value="{{ $oeuvre->code_titre }}"><br><br>
    <label for="">Titre: </label>
    <input type="text" name="titre" value="{{ $oeuvre->titre }}" required><br><br>
    <label for="">Catégorie: </label>
    <input type="text" name="categories" value="{{ $oeuvre->categorie }}"><br><br>
    <label for="">Numéro OMDA:</label>
    <input type="text" name="num" value="{{ $oeuvre->num }}"><br><br>
    <label for="">Nom: </label>
    <input type="text" name="nom" value="{{ $oeuvre->nom }}"><br><br> 
    <label for="">Pseudo:</label>
    <input type="text" name="pseudo" value="{{ $oeuvre->pseudo }}"><br><br>
    <label for="">Groupes:</label>
    <input type="text" name="groupes" value="{{ $oeuvre->groupes }}"><br><br>
    <label for="">Qualité: </label>
    <input type="text" name="qualite" value="{{ $oeuvre->qualite }}"><br><br>
    <label for="">Droit: </label>
    <input type="text" name="droit" value="{{ $oeuvre->droit }}"><br><br>
    <label for="">Part:</label>
    <input type="text" name="part" value="{{ $oeuvre->part }}"><br><br>
    <label for="">Hologramme:</label>
    <input type="text" name="hologramme" value="{{ $oeuvre->hologramme }}"><br><br>
    <button type="submit" class="btn btn-save">Modifier l'oeuvre</button>
    <a href="{{ route('oeuvres.index') }}" class="btn btn-cancel">Annuler</a>
    </form>
@else
    
    <form action="{{ route('oeuvres.update', $oeuvre->code_titre) }}" method="post">
    @csrf
    @method('PUT')
    <label for="">Date depôt: </label>
    <input type="date" name="date_depot" value="{{ $oeuvre->date_depot }}" required><br><br>
    <label for="">Code titre:</label>
    <input type="text" name="code_titre" value="{{ $oeuvre->code_titre }}"><br><br>
    <label for="">Titre: </label>
    <input type="text" name="titre" value="{{ $oeuvre->titre }}" required><br><br>
    <label for="">Catégorie: </label>
    <input type="text" name="categories" value="{{ $oeuvre->categories }}"><br><br>
    <label for="">Numéro OMDA:</label>
    <input type="text" name="num" value="{{ $oeuvre->num }}"><br><br>
    <label for="">Auteur:</label>
    <input type="text" name="auteur" value="{{$oeuvre->auteur }}"><br><br>
    <label for="">Part:</label>
    <input type="text" name="part" value="{{ $oeuvre->part }}"><br><br>
    <button type="submit" class="btn btn-save">Modifier l'oeuvre</button>
    <a href="{{ route('oeuvres.index') }}" class="btn btn-cancel">Annuler</a>
    </form>
@endif

        
    </form>
    </div>
</div>
</div>
</body>
</html>