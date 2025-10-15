<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des œuvres</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/png">
    <style>
    h1 {
      text-align: center;
      margin: 20px 0;
      font-size: 2.5rem;
      color: #2c3e50;
    }

            /* Grille des cartes */
    .cards-container {
      display: flex;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      padding: 40px;
      max-width: 1200px;
      margin:0 auto;
    }

    /* Carte */
    .card {
      width: 100%;
      position: relative;
      background: #fff;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-10px) scale(1.03);
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    /* Image */
    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .card:hover img {
      transform: scale(1.1);
    }

    /* Overlay sombre sur image */
    .card::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 180px;
      background: rgba(0,0,0,0.3);
      z-index: 1;
      transition: background 0.3s ease;
    }

    .card:hover::before {
      background: rgba(0,0,0,0.5);
    }

    /* Texte */
    .card-content {
      padding: 20px;
      text-align: center;
    }

    .card-content h2 {
      margin: 10px 0;
      font-size: 1.5rem;
      color: #2c3e50;
    }

    .card-content p {
      font-size: 0.95rem;
      color: #666;
    }

    .card-content button {
      margin-top: 15px;
      padding: 10px 20px;
      border: none;
      border-radius: 30px;
      background: #3498db;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .card-content button:hover {
      background: #2980b9;
    }
    /* Derniers artistes */
    .recent-oeuvre {
      background: #f8f9fa;
      padding: 20px;
      margin-top: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .recent-oeuvre h2 {
      font-size: 1.5rem;
      margin-bottom: 15px;
      color: #333;
    }

    .recent-oeuvre ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .recent-oeuvre li {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      font-size: 1rem;
    }

    .recent-oeuvre li:last-child {
      border-bottom: none;
    }
    </style>
</head>
<body>
<div class="container">
    <nav class="sidebar">
        <div class="logo">
            <h2>Office Malagasy du Droit d'Auteur</h2>
            <h3>O M D A</h3>
        </div>
        <ul>
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/oeuvre">Gestion des artistes</a></li>
            <li><a href="/oeuvres" class="active">Gestion des œuvres</a></li>
            <li><a href="/admin">Administration</a></li>
            <li><a href="/calendrier">Calendrier et Eveoeuvre</a></li>
            <li><a href="/logout" class="logout">Se déconnecter</a></li>
        </ul>
    </nav>

  <div class="main-conteneur">
    <h1>Gestion des œuvres</h1>

    <div class="cards-container">
        <div class="card" onclick="goCategory('LYR')">
           <img src="images/musique.jpg" alt="Musique">
            <div class="card-content">
                <h2>Musique 🎵</h2>
                <p>Découvrez et gérez les œuvres musicales.</p>
            </div>
        </div>

        <div class="card" onclick="goCategory('DRA')">
            <img src="images/dramatique.jpg" alt="Dramatique">
            <div class="card-content">
                <h2>Dramatique 🎭</h2>
                <p>Découvrez les œuvres dramatiques.</p>
            </div>
        </div>

        <div class="card" onclick="goCategory('LIT')">
            <img src="images/litterature.jpg" alt="Littérature">
            <div class="card-content">
                <h2>Littéraire 📖</h2>
                <p>Explorez les œuvres littéraires.</p>
            </div>
        </div>

        <div class="card" onclick="goCategory('AAV')">
            <img src="images/audiovisuel.jpg" alt="Audiovisuel">
            <div class="card-content">
                <h2>Audiovisuel 🎬</h2>
                <p>Parcourez les œuvres audiovisuelles.</p>
            </div>
        </div>
    </div>
    <div class="recent-oeuvre">
      <h2>🎤 Derniers oeuvres ajoutés</h2>
      <ul>
        @foreach($recentOeuvres as $oeuvres)
          <li>
            @if ($oeuvres->categorie === 'LYR')
                <strong>{{ $oeuvres->nom}} ({{ $oeuvres->pseudo }})</strong>
                ({{ $oeuvres->categorie }}) - <em>{{ $oeuvres->titre}}</em> 
                <em>{{ $oeuvres->date_depot }}</em>
            @else
                <strong>{{ $oeuvres->auteur }}</strong> 
                ({{ $oeuvres->categories }}) - <em>{{ $oeuvres->titre}}</em> 
                <em>{{ $oeuvres->date_depot }}</em>
            @endif
          </li>
        @endforeach
      </ul>
    </div>
</div>
</div>
<script>
function goCategory(cat) {
    window.location.href = "/oeuvres/category/" + cat;
}
</script>


</body>
</html>





















