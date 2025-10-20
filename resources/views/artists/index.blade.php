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
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
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
            top: 0;
            left: 0;
            width: 100%;
            height: 180px;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
            transition: background 0.3s ease;
        }

        .card:hover::before {
            background: rgba(0, 0, 0, 0.5);
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
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
            background-color: rgba(5, 160, 0, 0.699);
            color: white;
            padding: 12px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            z-index: 9999;
        }

        .chart-container {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .chart-container:hover {
            transform: scale(1.03);
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

@include('includes.loader')


<body>
    <div class="container">
        <nav class="sidebar">
            <div class="logo">
                <h2>Office Malagasy du Droit d'Auteur</h2>
                <h3>O.M.D.A</h3>
            </div>
            <ul class="onglets">

                <li><a href="/dashboard"><img
                            src="{{ asset('icons/monitoring_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}"
                            alt="Dashboard" width="24" height="24" alt=""> Dashboard</a></li>
                <li><a href="/artists" class="active"><img
                            src="{{ asset('icons/artist_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Artistes"
                            width="24" height="24"> Artistes</a></li>
                <li><a href="/oeuvres"><img
                            src="{{ asset('icons/speech_to_text_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}"
                            alt="Oeuvres" width="24" height="24">Oeuvres</a></li>
                <li><a href="/admin"><img
                            src="{{ asset('icons/admin_panel_settings_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.png') }}"
                            alt="Administration" width="24" height="24">Administration</a></li>
                <li><a href="/logout" class="logout" id="logoutLink"><img
                            src="{{ asset('icons/logout_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Logout"
                            width="24" height="24">Se déconnecter</a></li>

            </ul>
        </nav>
        {{-- notif pour suppression d'artiste --}}
        @if (session('success'))
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
                        <h2>Musique</h2>
                        <p>Découvrez et gérez les artistes du domaine musical.</p>
                    </div>
                </div>
                <div class="card" onclick="goCategory('DRA')">
                    <img src="images/dramatique.jpg" alt="Dramatique">
                    <div class="card-content">
                        <h2>Dramatique</h2>
                        <p>Retrouvez les artistes de la scène dramatique.</p>
                    </div>
                </div>
                <div class="card" onclick="goCategory('LIT')">
                    <img src="images/litterature.jpg" alt="Littérature">
                    <div class="card-content">
                        <h2>Littérature</h2>
                        <p>Explorez les artistes littéraires et écrivains.</p>
                    </div>
                </div>
                <div class="card" onclick="goCategory('AAV')">
                    <img src="images/audiovisuel.jpg" alt="Audiovisuel">
                    <div class="card-content">
                        <h2>Audiovisuel</h2>
                        <p>Parcourez les artistes du domaine audiovisuel.</p>
                    </div>
                </div>
            </div>

            <div class="bottom"
                style="display: flex; gap: 30px; max-width: 1200px; margin:auto;padding:0px 40px;align-items:center;">

                <div class="recent-artists">
                    <h2>Derniers artistes ajoutés</h2>
                    <ul>
                        @foreach ($recentArtists as $artist)
                            <li>
                                <strong>{{ $artist->nom }}</strong>
                                ({{ $artist->categorie }})
                                -
                                <em>{{ $artist->date_adh }}</em>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @php
                    $labels = [
                        'LYR' => 'Artistes en Musique',
                        'LIT' => 'Artistes en Littérature',
                        'DRA' => 'Artistes en Dramatique',
                        'AAV' => 'Artistes en Audiovisuel',
                    ];

                    $colors = [
                        'LYR' => '#3498db', // bleu
                        'LIT' => '#9b59b6', // violet
                        'DRA' => '#e67e22', // orange
                        'AAV' => '#2ecc71', // vert
                    ];
                @endphp
                {{-- <div class="chart-container" style="width: 400px; height: 400px;">
    <canvas id="artistsPieChart"></canvas> --}}
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctxPie = document.getElementById('artistsPieChart').getContext('2d');

                const artistsData = @json($artistsByCategory->toArray());

                const labels = artistsData.map(cat => "{{ $labels['" + cat.categorie + "'] ?? '' }}" || cat.categorie);
                const data = artistsData.map(cat => cat.total);

                const pieData = {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            '#3498db',
                            '#9b59b6',
                            '#e67e22',
                            '#2ecc71',
                            '#f1c40f',
                            '#e74c3c'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 8
                    }]
                };

                const pieConfig = {
                    type: 'doughnut',
                    data: pieData,
                    options: {
                        cutout: '60%',
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#333',
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Répartition des artistes par catégorie',
                                color: '#1f2937',
                                font: {
                                    size: 18,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                };

                new Chart(ctxPie, pieConfig);
            </script>

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
