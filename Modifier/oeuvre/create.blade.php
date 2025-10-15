<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout Oeuvre</title>

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
<body>
<div class="container">
  <nav class="sidebar">
    <div class="logo">
      <h2>Office Malagasy du Droit d'Auteur</h2>
      <h3>O.M.D.A</h3>
    </div>
    <ul class="onglets">
      <li><a href="/dashboard">Dashboard</a></li>
      <li><a href="/artists">Gestion des artistes</a></li>
      <li><a href="/oeuvres" class="active">Gestion des œuvres</a></li>
      <li><a href="/admin">Administration</a></li>
      <li><a href="/calendrier">Calendrier et Evenements</a></li>
      <li><a href="/logout" class="logout">Se déconnecter</a></li>
    </ul>
  </nav>


   <div class="main-conteneur">
@if ($artist->categorie === 'LYR')
<div id="addForm" style="margin-bottom: 20px; padding:10px; border:1px solid #ccc; border-radius:5px; background:#f9f9f9;">
    <form action="{{route('oeuvres.store')}}" method="post">
    @csrf
    <input type="hidden" name="type" value="musique">
    <div style="margin-bottom:5px;">
      <label for="">Date depôt: </label>
      <input type="date" name="date_depot" required>
    </div>
    <label for="">Code titre:</label>
    <input type="text" name="code_titre" required>
    <label for="">Titre: </label>
    <input type="text" name="titre" required>
    <label for="">Catégorie: </label>
    <input type="text" name="categories" value="{{ $artist->categorie }}" required>
    <label for="">Numéro OMDA:</label>
    <input type="text" name="num" value="{{ $artist->num }}" required>
    <label for="">Nom: </label>
    <input type="text" name="nom" value="{{ $artist->nom }}" required> 
    <label for="">Pseudo:</label>
    <input type="text" name="pseudo" value="{{ $artist->pseudo }}" required>
    <label for="">Groupes:</label>
    <input type="text" name="groupes" value="{{ $artist->groupes }}" required>
    <label for="">Qualité: </label>
    <input type="text" name="qualite" required>
    <label for="">Droit: </label>
    <input type="text" name="droit" required>
    <label for="">Part:</label>
    <input type="text" name="part" required>
    <label for="">Hologramme:</label>
    <input type="text" name="hologramme">
    <button class="btn btn-save" style="padding:5px 10px; cursor:pointer;">Ajouter une oeuvre</button><br>
    <a href="{{ route('oeuvres.index') }}" class="btn btn-cancel">Annuler</a>
    </form>
</div>
@else
<div id="addForm" style="margin-bottom: 20px; padding:10px; border:1px solid #ccc; border-radius:5px; background:#f9f9f9;">
    <form action="{{route('oeuvres.store')}}" method="post">
    @csrf
    
    <label for="">Date depôt: </label>
    <input type="date" name="date_depot" required>
    <label for="">Code titre:</label>
    <input type="text" name="code_titre" required>
    <label for="">Titre: </label>
    <input type="text" name="titre" required>
    <label for="">Catégorie: </label>
    <input type="text" name="categories" value="{{$artist->categorie}}" required>
    <label for="">Numéro OMDA:</label>
    <input type="text" name="num" value="{{$artist->num}}" required>
    <label for="">Auteur:</label>
    <input type="text" name="auteur" value="{{$artist->nom}}" required>
    <label for="">Part:</label>
    <input type="text" name="part" required>
    <button class="btn btn-save" style="padding:5px 10px; cursor:pointer;">Ajouter une oeuvre</button><br>
    <a href="{{ route('oeuvres.index') }}" class="btn btn-cancel">Annuler</a>
    </form>
</div>
@endif
</div>
</div>
</body>
</html>