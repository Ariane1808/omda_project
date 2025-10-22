<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

@include('includes.loader')

<body>

    <style>
        /* Excel-like table styles */
        .excel-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
        }

        .excel-table th,
        .excel-table td {
            border: 1px solid #0a0d11;
            padding: 8px 10px;
            vertical-align: middle;
        }

        .excel-table thead th {
            background: linear-gradient(180deg, #f3faf7 0%, #e6f2ea 100%);
            color: #0b4a33;
            font-weight: 600;
            text-align: left;
            border-bottom: 2px solid #9fc8a8;
        }

        .excel-table tbody tr:nth-child(even) {
            background-color: #fbfdfb;
        }

        .excel-table tbody tr:hover {
            background-color: #f1f7f1;
        }

        /* small subtle shadows to mimic sheet separation */
        .excel-table {
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.6);
        }

        /* action buttons */
        .action-btn { padding:5px 10px; border-radius:5px; text-decoration:none; color:#fff }
        .btn-edit { background:#3660a8 }
        .btn-delete { background:#d13b3b }

        #toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: green;
            color: white;
            padding: 12px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            z-index: 9999;
        }

    </style>
    <div class="container">
        <nav class="sidebar">
            <div class="logo">
                <h2>Office Malagasy du Droit d'Auteur</h2>
                <h3>O M D A</h3>
            </div>

            <ul class="onglets">

                <li><a href="/dashboard"><img src="{{ asset('icons/monitoring_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Dashboard" width="24" height="24" alt=""> Dashboard</a></li>
                <li><a href="/artists"><img src="{{ asset('icons/artist_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Artistes" width="24" height="24"> Artistes</a></li>
                <li><a href="/oeuvres" class="active"><img src="{{ asset('icons/speech_to_text_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Oeuvres" width="24" height="24">Oeuvres</a></li>
                <li><a href="/admin"><img src="{{ asset('icons/admin_panel_settings_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Administration" width="24" height="24">Administration</a></li>
                <li><a href="/logout" class="logout" id="logoutLink"><img src="{{ asset('icons/logout_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Logout" width="24" height="24">Se déconnecter</a></li>


        </nav>

        {{-- notif pour modifications d'oeuvre --}}
        @if(session('success'))
        <div id="toast" class="fixed bottom-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow-lg z-50">
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
            <div style="display: flex; align-items:center; justify-content: space-between;">
                
                <div>
                <h2>Liste des oeuvres</h2>
                <!-- Export CSV button -->
                <br><a href="{{ route('oeuvres.export', $categorie) }}" style="padding:8px 12px; background:#10B981; color:white; border-radius:6px; text-decoration:none;">Exporter oeuvres (CSV)</a>
                </div>
                <div style="display: flex; justify-content: flex-end; margin-bottom: 10px; position: relative; width: 220px;">

                    <div style="display: flex; align-items:center; justify-content: space-between;">

                        <div style="display: flex; gap: 10px; align-items: center;">

                            <!-- Recherche -->
                           <form method="GET" action="{{ route('oeuvres.byCategory', $categorie) }}"
                                style="position: relative;">
                                <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                                    placeholder="Rechercher..." style="padding:5px 10px; width:200px;" class="input">
                                <span id="clearSearch"
                                    style="cursor:pointer; border: 1px solid rgb(224, 214, 214); padding:3px 5px 5px ; position: absolute; background-color:rgb(197, 29, 29); color:#ccc">
                                    &times;
                                </span>
                                <button type="submit"
                                    style="margin-top:10px; padding:5px; display:flex; align-items:center; gap:10px;"><img
                                        src="{{ asset('icons/search_24dp_000000_FILL0_wght400_GRAD0_opsz24.png') }}"
                                        alt="Search" width="16" height="16" alt="">Rechercher</button>
                            </form>

                        </div>
                    </div>

                    <!-- <input type="text" id="searchInput" placeholder="Rechercher..." style="padding:5px 10px; width:100%;"> -->

                </div>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h1>Œuvres - {{ $categorie }}</h1>
                
                <div style="display:flex; align-items:center; gap:12px;">
                    {{-- pagination --}}
                    {{ $oeuvres->links() }}

                    

                    <form onsubmit="goToPage2(event)" style="display:flex; align-items:center; gap:8px; margin-left:8px;">
                        <label style="margin-right:4px;">Aller à la page :</label>
                        <input type="number" id="pageInput2" min="1" max="{{ $oeuvres->lastPage() }}" style="width:60px; padding:3px;">
                        <button type="submit" style="padding:5px;">OK</button>
                    </form>
                </div>
            </div>

            @if($oeuvres->count() > 0)
            <table class="excel-table">
                <thead>
                    <tr>
                        <th>Code titre</th>
                        <th>Titre</th>
                        <th>Numéro OMDA</th>
                        @if ($categorie === 'LYR')
                        <th>Nom</th>
                        <th>Pseudo</th>
                        <th>Groupe</th>
                        <th>Qualite</th>
                        <th>Part</th>
                        <th>Droit</th>
                        <th>Hologramme</th>
                        @else
                        <th>Auteur</th>
                        <th>Part</th>
                        @endif
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($oeuvres as $oeuvre)
                    <tr>
                        <td>{{ $oeuvre->code_titre}}</td>
                        <td>{{ $oeuvre->titre }}</td>
                        <td><a href="{{ route('artists.show', $oeuvre->num) }}">{{ $oeuvre->num }}</a></td>
                        @if ($oeuvre->categorie === 'LYR')

                        <td>{{ $oeuvre->nom }}</td>
                        <td>{{ $oeuvre->pseudo }}</td>
                        <td>{{ $oeuvre->groupes}}</td>
                        <td>{{ $oeuvre->qualite }}</td>
                        <td>{{ $oeuvre->part }}</td>
                        <td>{{ $oeuvre->droit }}</td>
                        <td>{{ $oeuvre->hologramme }}</td>
                        @else

                        <td>{{ $oeuvre->auteur }}</td>
                        <td>{{ $oeuvre->part}}</td>
                        @endif
                        <td>{{ $oeuvre->date_depot }}</td>
                        <td style="border: none; padding:10px;">
                            <!-- modif -->
                            <a href="{{ route('oeuvres.edit', $oeuvre->code_titre) }}" style="padding:5px 10px; background:#3660a8; color:white; border-radius:5px; text-decoration:none;"><img src="{{ asset('icons/edit_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Edit" width="16" height="16" alt=""></a>
                            <!-- suppr -->
                            <form action="{{ route('oeuvres.destroy', $oeuvre->code_titre) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cet oeuvre ?');"><img src="{{ asset('icons/delete_24dp_E3E3E3_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Delete" width="16" height="16" alt=""></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top: 15px; display:flex; align-items:center; gap:10px;  flex-direction:column-reverse;">

                {{-- pagination --}}
                {{ $oeuvres->links() }}

                <form onsubmit="goToPage(event)" style="display:flex; align-items:center; gap:5px;">
                    <label>Aller à la page :</label>
                    <input type="number" id="pageInput" min="1" max="{{ $oeuvres->lastPage() }}" style="width:60px; padding:3px;">
                    <button type="submit" style="padding:5px;">OK</button>
                </form>
            </div>
            @else
            <p>Aucune œuvre dans cette catégorie.</p>
            @endif
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // navigation par clic sur la ligne, sauf si on clique un bouton/lien/champ
            document.querySelectorAll('#artistTable tbody tr').forEach(tr => {
                tr.addEventListener('click', function(e) {
                    if (e.target.closest('button, a, input, .no-row-nav')) return; // on ignore
                    window.location = this.dataset.href;

                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // navigation par clic sur la ligne, sauf si on clique un bouton/lien/champ
            document.querySelectorAll('#artistTable thead tr th').forEach(tr => {
                tr.addEventListener('click', function(e) {
                    if (e.target.closest('button, a, input, .no-row-nav')) return; // on ignore
                    window.location = this.dataset.href;

                });
            });
        });


       
        const clearBtn = document.getElementById('clearSearch');
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('#artistTable tbody tr');

        // Réinitialiser la recherche
        

clearBtn.addEventListener('click', function() {
    searchInput.value = '';
    // Supprime le paramètre 'search' de l'URL et recharge proprement la page
    const url = new URL(window.location.href);
    url.searchParams.delete('search');
    window.location.href = url.toString();
});

        // Filtrage en temps réel
        // searchInput.addEventListener('keyup', function() {
        //     const filter = searchInput.value.toLowerCase();
        //     rows.forEach(row => {
        //         const text = row.textContent.toLowerCase();
        //         row.style.display = text.includes(filter) ? '' : 'none';
        //     });
        // });
        function goToPage(e) {
            e.preventDefault();
            const page = document.getElementById('pageInput').value;
            if (page) {
                const url = new URL(window.location.href);
                url.searchParams.set('page', page);
                window.location.href = url.toString();
            }

        }

        function goToPage2(e) {
            e.preventDefault();
            const page = document.getElementById('pageInput2').value;
            if (page) {
                const url = new URL(window.location.href);
                url.searchParams.set('page', page);
                window.location.href = url.toString();
            }

        }

    </script>


</body>
