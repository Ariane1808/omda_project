<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des artistes</title>
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
      margin: 0 auto;
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

    /* Contenu de la carte */
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
    .recent-artists {
      background: #f8f9fa;
      padding: 20px;
      margin-top: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .recent-artists h2 {
      font-size: 1.5rem;
      margin-bottom: 15px;
      color: #333;
    }

    .recent-artists ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .recent-artists li {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      font-size: 1rem;
    }

    .recent-artists li:last-child {
      border-bottom: none;
    }
    #toast {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background-color: rgb(212, 0, 0);
    color: white;
    padding: 12px;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    z-index: 9999;
  }

  </style>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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
      <li><a href="/artists" class="active">Gestion des artistes</a></li>
      <li><a href="/oeuvres">Gestion des œuvres</a></li>
      <li><a href="/admin">Administration</a></li>
      <li><a href="/calendrier">Calendrier et Evenements</a></li>
      <li><a href="/logout" class="logout">Se déconnecter</a></li>
    </ul>
  </nav>
  {{-- notif pour suppression d'artiste --}}
@if(session('success'))
    <div id="toast" class="fixed bottom-5 right-5 bg-red-600 text-white px-4 py-2 rounded shadow-lg z-50">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) toast.remove();
        }, 3000);
    </script>
@endif
  <div class="main-conteneur">
    <h1>Gestion des artistes</h1>
    <div class="cards-container">
      <div class="card" onclick="goCategory('LYR')">
        <img src="images/musique.jpg" alt="Musique">
        <div class="card-content">
          <h2>Musique 🎵</h2>
          <p>Découvrez et gérez les artistes du domaine musical.</p>
        </div>
      </div>
      <div class="card" onclick="goCategory('DRA')">
        <img src="images/dramatique.jpg" alt="Dramatique">
        <div class="card-content">
          <h2>Dramatique 🎭</h2>
          <p>Retrouvez les artistes de la scène dramatique.</p>
        </div>
      </div>
      <div class="card" onclick="goCategory('LIT')">
        <img src="images/litterature.jpg" alt="Littérature">
        <div class="card-content">
          <h2>Littérature 📖</h2>
          <p>Explorez les artistes littéraires et écrivains.</p>
        </div>
      </div>
      <div class="card" onclick="goCategory('AAV')">
        <img src="images/audiovisuel.jpg" alt="Audiovisuel">
        <div class="card-content">
          <h2>Audiovisuel 🎬</h2>
          <p>Parcourez les artistes du domaine audiovisuel.</p>
        </div>
      </div>
    </div>

    <div class="recent-artists">
      <h2>🎤 Derniers artistes ajoutés</h2>
      <ul>
        @foreach($recentArtists as $artist)
          <li>
            <strong>{{ $artist->nom }}</strong> 
            ({{ $artist->categorie }}) - 
            <em>{{ $artist->date_adh }}</em>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>

<script>
  function goCategory(cat) {
    window.location.href = "/artists/category/" + cat;
  }
</script>
</body>
</html>
