<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard OMDA</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
.cards-container {
    display: flex;
    /* justify-content: center; */
    /* margin-top: 20px; */
    gap:20px;
    height: 120px;
}

/* .card {
    background: linear-gradient(135deg, #fafafa, var(--color-primary));
    color: rgb(47, 47, 100);
    padding: 30px;
    border-radius: 12px;
    /* text-align: center; */
    /* width: 35%;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transition: transform 0.3s ease;
    height: 100%; */
/* } */

.card {
  color: rgb(47, 47, 100);
  padding: 1rem;
  background-color: #e5e7eb;
  box-shadow: -10px -10px 20px white, 10px 10px 20px rgb(153, 161, 175), inset -10px -10px 20px rgb(209, 213, 220);
  width: 35%;
  border-radius: 20px;
  transition: transform 0.3s ease;
  height: 100%;
}

.data p {
  margin-top: 1rem;
  margin-bottom: 1rem;
  color: #1f2937;
  font-size: 2.25rem;
  line-height: 2.5rem;
  font-weight: 700;
  text-align: left;
}

.card:hover {
    transform: scale(1.05);
}
.col-md-3{
    width: 25%;
      border-radius: 12px;
     box-shadow: 0 4px 15px rgba(0,0,0,0.2);
     padding: 20px;
     color: white;
}

.courbe {
    background: #ffffff; /* fond clair */
    border-radius: 12px;
    padding: 20px;
    margin-top: 20px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    width: 50%;
    border: 3px solid rgba(75, 192, 192, 1);
}

.courbe h3 {
    font-size: 1.2rem;
    margin-bottom: 15px;
    color: #1f2937; /* texte sombre lisible */
    text-align: center;
    font-weight: 600;
}

.courbe canvas {
    width: 100% !important;
    height: auto !important;
    max-height: 300px;
    display: block;
}

.info{
    display: flex;
    flex-direction: column;
    gap: 30px;
}
.table{
    width: 50%;
}
.info span{
    color: #ee6060;
}
.bottom{
    display: flex;
    align-items: center;
    position: relative;
    margin-top: 20px;
}

/* Aside modernisé avec slide in/out */
aside {
    background: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    /* margin: 20px; */
    padding: 30px;
    gap: 20px;
    width: 25%;
    border-radius: 30px 0 0 30px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.13);
    text-align: center;

    /* Animation d’entrée */
    opacity: 0;
    transform: translateX(100%);
    animation: slideInRight 0.8s ease forwards;
    position: absolute;
    right: 0;
    height: 115%;
    bottom: 0; 
    overflow-x: auto;
}

@keyframes slideInRight {
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideOutRight {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
}


aside.exit {
    animation: slideOutRight 0.6s ease forwards;
}


aside img {
    width: 160px;
    height: 160px;
    object-fit: contain;
    margin-bottom: 15px;
    filter: drop-shadow(0 4px 15px rgba(0, 0, 0, 0.2));
}
aside img:hover {
    transform: scale(1.05) rotate(2deg);
}

/* Titres */
aside h2 {
    font-size: 1.3rem;
    color: #111827;
    font-weight: 600;
    animation: fadeIn 1s ease forwards;
}

aside h3.username {
    font-size: 1.1rem;
    color: #2563eb;
    margin-bottom: 20px;
    font-weight: 500;
    animation: fadeIn 1.2s ease forwards;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Liens */
.link {
    width: 100%;
}

.link ul {
    display: flex;
    flex-direction: column;
    gap: 20px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.link a {
    display: flex;
    align-items: center;
    padding: 20px;
    border-radius: 20px; 
    box-shadow: 0 6px 16px rgba(0,0,0,0.13);
    color: var(--color-info-dark);
    gap: 1rem;
    text-decoration: none;
    transition: all 300ms ease;
    position: relative;
    overflow: hidden;
}

.link a:hover {
    background-color: rgb(211, 207, 207);
    color: #111827;
    transform: translateX(5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

/* Vague bleue au hover */
.link a::after {
    content: "";
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: rgba(37, 99, 235, 0.1);
    transition: left 0.4s ease;
}
.link a:hover::after {
    left: 0;
}
/* .sidebar img {
    filter: invert(1); /* rend les icônes blanches sur fond sombre */

@media (max-width: 1366px){
    aside{
        padding:20px;
        height: 115%;
    }
    aside img{
        width: 130px;
        height: 130px;

    }
    aside h2{
        font-size: 1rem;
    }
    aside h3.username{
        font-size: 1.2rem;
        margin: 0;
    }
}
    </style>
</head>

@include('includes.loader')

<body>

<div class="container">



    <nav class="sidebar">
        <div class="logo">
        <h2>Office Malagasy du Droit d'Auteur</h2>
        <h3>O M D A</h3>
        </div>
        <ul class="onglets">
    
            <li><a href="/dashboard" class="active"><img src="{{ asset('icons/monitoring_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Dashboard" width="24" height="24" alt=""> Dashboard</a></li>
            <li><a href="/artists" ><img src="{{ asset('icons/artist_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Artistes" width="24" height="24">  Artistes</a></li>
            <li><a href="/oeuvres" ><img src="{{ asset('icons/speech_to_text_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Oeuvres" width="24" height="24"> Oeuvres</a></li>
            <li><a href="/admin"  ><img src="{{ asset('icons/admin_panel_settings_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Administration" width="24" height="24">Administration</a></li>
            <li><a href="/logout" class="logout" id="logoutLink"><img src="{{ asset('icons/logout_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Logout" width="24" height="24">Se déconnecter</a></li>

        </ul>
    </nav>
<div class="main-conteneur">
    <!-- Contenu principal -->
    <div class="main-content">

        {{-- <div class="blocks">
            <div class="block artiste" onclick="window.location.href='/artists'">
                <span>Artistes</span>
            </div>
            <div class="block oeuvre" onclick="window.location.href='/oeuvres'">
                <span>Œuvres</span>
            </div>
        </div> --}}
        <div class="info">
            <h1><span>O</span>ffice <span>M</span>alagasy du <span>D</span>roit d'<span>A</span>uteur</h1>
             <div class="cards-container">
                <div class="card"  class="block artiste" onclick="window.location.href='/artists'">
                    <h3>Nombre total des artistes</h3>
                    
                    <div class="data"><p style="font-size: 2rem; font-weight: bold;">{{ $totalArtists }}</p></div>
                </div>
                <div class="card" class="block oeuvre" onclick="window.location.href='/oeuvres'">
                    <h3>Nombre total des oeuvres</h3>
                    <div class="data"><p style="font-size: 2rem; font-weight: bold;">{{ $totalOeuvres }}</p></div>
                </div>
                {{-- miaraka amle atsy ambany --}}
                <div class="col-md-3" style="color: rgb(47, 47, 100);padding: 1rem;background-color: #e5e7eb;box-shadow: -10px -10px 20px white, 10px 10px 20px rgb(153, 161, 175), inset -10px -10px 20px rgb(209, 213, 220);width: 35%;border-radius: 20px;transition: transform 0.3s ease;height: 100%;">  
                    <div>
                        <div class="card-body">
                             <h4 class="card-title">Moyenne d’œuvres par artiste</h4>
                             <div class="data"><p class="card-text fs-3" style="font-size: 2rem; font-weight: bold;">{{ $moyenneOeuvresParArtiste }}</p></div>
                        </div>
                    </div>
                </div>
            </div>
<div style="display:flex;">
<div class="table">
 @php
    $labels = [
        'LYR' => 'Artistes en Musique',
        'LIT' => 'Artistes en Littérature',
        'DRA' => 'Artistes en Dramatique',
        'AAV' => 'Artistes en Audiovisuel',
    ];

    $colors = [
        'LYR' => '#3498db',   // bleu
        'LIT' => '#9b59b6',   // violet
        'DRA' => '#e67e22',   // orange
        'AAV' => '#2ecc71',   // vert
    ];
@endphp

<table style="width:95%;  overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.3);">
    <thead>
        <tr style="background:#2c2c3c; text-align:left;">
            <th style="padding:12px;">Catégories</th>
            <th style="padding:12px;">Total</th>
            <th style="padding:12px;">Proportion</th>
        </tr>
    </thead>
    <tbody>
        @foreach($artistsByCategory as $cat)
            @php
                $percent = $totalArtists > 0 ? ($cat->total / $totalArtists) * 100 : 0;
            @endphp

            <tr style="border-bottom:1px solid #444;">
                <td style="padding:12px;">{{ $labels[$cat->categorie] ?? $cat->categorie }}</td>
                <td style="padding:12px; font-weight:bold;">{{ $cat->total }}</td>
                <td style="padding:12px;">
                    <div style="background:#333; border-radius:8px; overflow:hidden; height:14px; width:100%;">
                        <div style="width:{{ $percent }}%; height:100%; background:{{ $colors[$cat->categorie] ?? '#555' }}; transition:width 0.6s ease;"></div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


</div>

<div class="table">
<!-- Œuvres par catégorie -->
 @php
    // Couleurs par catégorie
    $colors = [
        'Oeuvres Musicales' => '#3498db',     // bleu
        'Oeuvres Littéraires' => '#9b59b6',  // violet
        'Oeuvres Dramatiques' => '#e67e22',  // orange
        'Oeuvres Audiovisuelles' => '#2ecc71', // vert
    ];
@endphp

<table style="width:95%; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.3);">
    <thead>
        <tr style="background:#2c2c3c; text-align:left;">
            <th style="padding:12px;">Catégories</th>
            <th style="padding:12px;">Total</th>
            <th style="padding:12px;">Proportion</th>
        </tr>
    </thead>
    <tbody>
        @foreach($oeuvresByCategory as $cat)
            @php
                // Pourcentage basé sur le total général
                $percent = $totalOeuvres > 0 ? ($cat->total / $totalOeuvres) * 100 : 0;
            @endphp
             <tr style="border-bottom:1px solid #444;">
                <td style="padding:12px;">{{ $cat->categories }}</td>
                <td style="padding:12px;  font-weight:bold;">{{ $cat->total }}</td>
                <td style="padding:12px;">
                   
                        <div style="background:#333; border-radius:8px; overflow:hidden; height:14px; width:100%;">
                            <div style="width:{{ $percent }}%; height:100%; background:{{ $colors[$cat->categories] ?? '#555' }}; transition:width 0.6s ease;"></div>
                         </div>
                    
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
</div>


        </div>
           
<div style="display: flex; flex-direction:column; gap:20px; width:25%; margin-top:15px; height: 350px;">
<div class="col-md-3" style="background-color:#3498db; ">
    <div>
        <div class="card-body">
            <h4 class="card-title">Artistes inscrits cette année</h4>
            <p class="card-text fs-3" style="font-size: 2rem; font-weight: bold;">{{ $artistsThisYear }}</p>
        </div>
    </div>
</div>
<div class="col-md-3" style="background-color: #2ecc71">
    <div>
        <div class="card-body">
            <h4 class="card-title">Œuvres déposées cette année</h4>
            <p class="card-text fs-3" style="font-size: 2rem; font-weight: bold;">{{ $oeuvresThisYear }}</p>
        </div>
    </div>
</div>


@if($topArtist)
<div class="col-md-3"  style="background:#ee6060; color:white; padding:30px; border-radius:12px; text-align:center;">
    <h4>Top Artiste</h4>
    <p style="font-size:1.5rem; font-weight:bold;">
        {{ $topArtist->pseudo }} ({{ $topArtist->total_oeuvres }} oeuvres {{ $topArtist->categorie }})
    </p>
</div>
@endif


</div>


    </div>
    <div class="bottom">
  <div class="courbe" style="padding:20px; margin-top:30px;">
    <h3>Variation des adhésions d’artistes et dépôts d’œuvres cette année </h3>
    <canvas id="adhesionsOeuvresChart" width="400" height="150"></canvas>
</div>

<div class="calendrier" style="width:25%;">



</div>

<div class="user">

<aside class="silde-in-right">
    <img src="images/logo3.png" alt="">
    <h2>Vous êtes connecté en tant que : </h2>
    <h3 class="username">{{$username}}</h3>
    <p>Votre tableau de bord est prêt. Vous pouvez gérer, affiner et optimiser chaque détail.</p>
</aside>



</div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('adhesionsOeuvresChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
            ],
            datasets: [
                {
                    label: 'Adhésions',
                    data: @json(array_values($adhesionsByMonth)),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Œuvres déposées',
                    data: @json(array_values($mergedOeuvres)), // il faut calculer ça dans le contrôleur
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Évolution des adhésions et dépôts d’œuvres en ' + new Date().getFullYear()
                }
            }
        }
    });
</script>




</body>


</html>
