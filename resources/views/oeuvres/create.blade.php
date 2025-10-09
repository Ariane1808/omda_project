<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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
    <form action="{{route('oeuvres.store')}}" method="post">
    @csrf
    <input type="hidden" name="type" value="musique">
    <label for="">Date depôt: </label>
    <input type="date" name="date_depot" required><br><br>
    <label for="">Code titre:</label>
    <input type="text" name="code_titre"><br><br>
    <label for="">Titre: </label>
    <input type="text" name="titre" required><br><br>
    <label for="">Catégorie: </label>
    <input type="text" name="categories" value="{{ $artist->categorie }}"><br><br>
    <label for="">Numéro OMDA:</label>
    <input type="text" name="num" value="{{ $artist->num }}"><br><br>
    <label for="">Nom: </label>
    <input type="text" name="nom" value="{{ $artist->nom }}"><br><br> 
    <label for="">Pseudo:</label>
    <input type="text" name="pseudo" value="{{ $artist->pseudo }}"><br><br>
    <label for="">Groupes:</label>
    <input type="text" name="groupes" value="{{ $artist->groupes }}"><br><br>
    <label for="">Qualité: </label>
    <input type="text" name="qualite"><br><br>
    <label for="">Droit: </label>
    <input type="text" name="droit"><br><br>
    <label for="">Part:</label>
    <input type="text" name="part"><br><br>
    <label for="">Hologramme:</label>
    <input type="text" name="hologramme"><br><br>
    <button>Ajouter une oeuvre</button>
    </form>
@else
    <form action="{{route('oeuvres.store')}}" method="post">
    @csrf
    
    <label for="">Date depôt: </label>
    <input type="date" name="date_depot" required><br><br>
    <label for="">Code titre:</label>
    <input type="text" name="code_titre"><br><br>
    <label for="">Titre: </label>
    <input type="text" name="titre" required><br><br>
    <label for="">Catégorie: </label>
    <input type="text" name="categories" value="{{$artist->categorie}}"><br><br>
    <label for="">Numéro OMDA:</label>
    <input type="text" name="num" value="{{$artist->num}}"><br><br>
    <label for="">Auteur:</label>
    <input type="text" name="auteur" value="{{$artist->nom}}"><br><br>
    <label for="">Part:</label>
    <input type="text" name="part"><br><br>
    <button>Ajouter une oeuvre</button>
    </form>
@endif
</div>
</div>