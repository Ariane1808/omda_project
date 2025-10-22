<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    .artist-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .artist-table th{
        border: 1px solid #ccc;
        border: 1px solid #ccc;
        padding: 8px 8px;
    }
    .artist-table td {
        border: 1px solid #ccc;
        padding: 4px 8px;
        border: 1px solid #ccc;
    }

    .artist-table th {
        background-color: #f2f2f2;
    }

    .artist-row {
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .artist-row:hover {
        background-color: #e0e0e0;
    }

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

    th {
        cursor: pointer;
    }

    /* .button::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  transform: scaleX(0);
  transform-origin: 0 50%;
  width: 100%;
  height: inherit;
  border-radius: inherit;
  background: linear-gradient( 82.3deg, rgba(150, 93, 233, 1) 10.8%, rgba(99, 88, 238, 1) 94.3% );
  transition: all 0.475s;
}

.button {
  margin: 20px auto;
  position: relative;
  overflow: hidden;
  height: 3rem;
  padding: 0 2rem;
  border-radius: 1.5rem;
  background: #3d3a4e;
    background-size: auto;
  background-size: 400%;
  color: #fff;
  border: none;
  cursor: pointer;
} */
    .button {
        position: relative;
        overflow: hidden;
        height: 3rem;
        padding: 0 2rem;
        border-radius: 1.5rem;
        /* background: #3d3a4e; */
        background-size: 400%;
        color: #3d3a4e;
        border: none;
        cursor: pointer;
        background-color: #e5e7eb;
        display: flex;
        align-items: center;
        gap: 10px;
        border-radius: 30px;
        padding: 10px;
        border: none;
        box-shadow: -10px -10px 20px white, 10px 10px 20px rgb(153, 161, 175), inset -10px -10px 20px rgb(209, 213, 220);
    }

    .button:hover {
        color: #fff;
    }

    .button:hover::before {
        transform: scaleX(1);
    }

    .button-content {
        position: relative;
        z-index: 1;
    }

    .button::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        transform: scaleX(0);
        transform-origin: 0 50%;
        width: 100%;
        height: inherit;
        border-radius: inherit;
        background: linear-gradient(82.3deg,
                rgba(150, 93, 233, 1) 10.8%,
                rgba(99, 88, 238, 1) 94.3%);
        transition: all 0.475s;
    }
</style>

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('css/bycategory.css') }}"> -->

@include('includes.loader')


<body>
    <div class="container">
        <nav class="sidebar">
            <div class="logo">
                <h2>Office Malagasy du Droit d'Auteur</h2>
                <h3>O M D A</h3>
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
                <li><a href="/logout" class="logout"><img
                            src="{{ asset('icons/logout_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Logout"
                            width="24" height="24">Se déconnecter</a></li>

            </ul>
        </nav>
    {{-- notif pour modifications d'artiste --}}
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
        <h2>Liste des artistes</h2>
        <div style="display: flex; justify-content: flex-end; margin-bottom: 10px; position: relative; width: 220px;">
        
      <div style="display: flex; align-items:center; justify-content: space-between;">

    <div style="display: flex; gap: 10px; align-items: center;">

        <!-- Recherche -->
        <form method="GET" action="{{ route('artists.byCategory', $categorie) }}" style="position: relative;">
            <input type="text" id="searchInput" name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Rechercher..." 
                   style="padding:5px 10px; width:200px;">
            <span id="clearSearch" style="cursor:pointer; border: 1px solid rgb(224, 214, 214); padding:3px 5px 5px ; position: absolute; background-color:rgb(197, 29, 29); color:#ccc">
                  &times;
            </span>
            <button type="submit" style="margin-top:10px; padding:5px;">Rechercher</button>
        </form>

    </div>
</div>
        
        <!-- <input type="text" id="searchInput" placeholder="Rechercher..." style="padding:5px 10px; width:100%;"> -->
           
        </div>
        </div>
        <button id="addBtn" class="button" style="padding:5px 10px; cursor:pointer;"><span class="button-content">Ajouter un artiste</span></button>

        <!-- Formulaire caché au départ -->
        <div id="addForm" style="display:none; margin-bottom: 20px; padding:10px; border:1px solid #ccc; border-radius:5px; background:#f9f9f9;">
            <form action="{{ route('artists.store') }}" method="POST">
                @csrf
                
                    <label>Numéro Wipo:</label>
                    <input type="text" name="num_wipo" required>
                
                
                    <label>Date d'adhésion:</label>
                    <input type="date" name="date_adh" required>
                
                <!-- 
                    <label>Numéro Omda:</label>
                    <input type="text" name="num" required>
                </div> -->
                
                    <label>Catégories:</label>
                    <!-- <input type="text" name="categorie" value= ""> -->
                    <select name="categorie" id="">
                        <option value="LIT" @selected($categorie == 'LIT')>Littérature</option>
                        <option value="LYR" @selected($categorie == 'LYR')>Musique</option>
                        <option value="DRAM" @selected($categorie == 'DRA')>Dramatique</option>
                        <option value="AAV" @selected($categorie == 'AAV')>Audiovisuel</option>
                    </select>

                
                
                    <label>Nom:</label>
                    <input type="text" name="nom" required>
                
                
                    <label>Pseudo:</label>
                    <input type="text" name="pseudo" required>
                
                
                    <label>Groupe:</label>
                    <input type="text" name="groupes" required>
                
                
                    <label>contact:</label>
                    <input type="text" name="contact" required>
                
                
                    <label>Email:</label>
                    <input type="text" name="email" required>
                
                
                    <label>Adresse:</label>
                    <input type="text" name="adresse" required>
                
                
                    <label>Province:</label>
                   <select name="province" id="">
                        <option value="ANTANANARIVO">ANTANANARIVO</option>
                        <option value="TOAMASINA">TOAMASINA</option>
                        <option value="ANTSIRANANA">ANTSIRANANA</option>
                        <option value="MAHAJANGA">MAHAJANGA</option>
                        <option value="FIANARANTSOA">FIANARANTSOA</option>
                        <option value="TOLIARA">TOLIARA</option>
                     </select>
                
                
                    <!-- <input type="text" name="sexe" required> -->
                     <label>Sexe :</label>
                     <input type="radio" name="sexe" value="H" id="homme" required>
                     <label for="homme">Homme</label>

                     <input type="radio" name="sexe" value="F" id="femme">
                     <label for="femme">Femme</label>

                
                
                    <label>CIN:</label>
                    <input type="text" name="cin" required>
                
                
                    <label>Date de naissande:</label>
                    <input type="date" name="date_naissance" required>
                
                
                    <label>Pension:</label>
                    <input type="text" name="pension" required>
                
                    <label>Statut:</label>
                    <input type="text" name="statut">
                
                
                    <label>Hologramme:</label>
                    <input type="text" name="hologramme">
                

                <button type="submit" style="padding:5px 10px; cursor:pointer;">Enregistrer</button>
            </form>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>Artistes - {{ $categorie }}</h2>

    <div style="margin-top: 15px; display:flex; align-items:center; gap:10px;">
       
       {{-- pagination --}}
            {{ $artists->links() }}

        <form onsubmit="goToPage(event)" style="display:flex; align-items:center; gap:5px;">
            <label>Aller à la page :</label>
            <input type="number" id="pageInput" min="1" max="{{ $artists->lastPage() }}" style="width:60px; padding:3px;">
            <button type="submit" style="padding:5px;">OK</button>
        </form>
    </div>
        </div>
@if($artists->count() > 0)
<table class="artist-table" id="artistTable">
     <thead>
                        <tr>
                            <th
                                data-href="{{ route('artists.byCategory', ['categorie' => $categorie, 'sort' => 'num', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}">
                                {{-- <a href="{{ route('artists.byCategory', ['categorie' => $categorie, 'sort' => 'num', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"> --}}
                                Num
                                @if ($sort === 'num')
                                    {{ $order === 'asc' ? '▲' : '▼' }}
                                @endif
                                {{-- </a> --}}
                            </th>
                            <th
                                data-href="{{ route('artists.byCategory', ['categorie' => $categorie, 'sort' => 'nom', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}">
                                {{-- <a href="{{ route('artists.byCategory', ['categorie' => $categorie, 'sort' => 'nom', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"> --}}
                                Nom
                                @if ($sort === 'nom')
                                    {{ $order === 'asc' ? '▲' : '▼' }}
                                @endif
                                {{-- </a> --}}
                            </th>
                            <th
                                data-href="{{ route('artists.byCategory', ['categorie' => $categorie, 'sort' => 'pseudo', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}">
                                {{-- <a href="{{ route('artists.byCategory', ['categorie' => $categorie, 'sort' => 'pseudo', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"> --}}
                                Pseudo
                                @if ($sort === 'pseudo')
                                    {{ $order === 'asc' ? '▲' : '▼' }}
                                @endif
                                {{-- </a> --}}
                            </th>
                            <th
                                data-href="{{ route('artists.byCategory', ['categorie' => $categorie, 'sort' => 'date_naissance', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}">
                                {{-- <a href="{{ route('artists.byCategory', ['categorie' => $categorie, 'sort' => 'date_naissance', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"> --}}
                                Date de naissance
                                @if ($sort === 'date_naissance')
                                    {{ $order === 'asc' ? '▲' : '▼' }}
                                @endif
                                {{-- </a> --}}
                            </th>
                            <th
                                data-href="{{ route('artists.byCategory', ['categorie' => $categorie, 'sort' => 'contact', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}">
                                {{-- <a href="{{ route('artists.byCategory', ['categorie' => $categorie, 'sort' => 'contact', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"> --}}
                                Contact
                                @if ($sort === 'contact')
                                    {{ $order === 'asc' ? '▲' : '▼' }}
                                @endif
                                {{-- </a> --}}
                            </th>
                            <td style="padding: 8px 8px;">Action</td>
                        </tr>
                    </thead>
    <tbody>
        @foreach($artists as $artist)
       
      <tr class="artist-row" data-href="{{ route('artists.show', $artist->num) }}" style="cursor:pointer;">

        <td>{{ $artist->num }}</td>
            <td>{{ $artist->nom }}</td>
            <td>{{ $artist->pseudo }}</td>
            <td>{{ $artist->date_naissance }}</td>
            <td>{{ $artist->contact }}</td>
            
             <td style="border:none;">
                                    <!-- Bouton modifier -->
                                    <a href="{{ route('artists.edit', $artist->num) }}"
                                        style="padding:5px 10px; background:#3660a8; color:white; border-radius:5px; text-decoration:none;"><img
                                            src="{{ asset('icons/edit_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.png') }}"
                                            alt="Edit" width="16" height="16" alt=""></a>
                                    <!-- Bouton Supprimer -->
                                    <form action="{{ route('artists.destroy', $artist->num) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <!--@csrf= (Cross-Site Request Forgery). protection contre les sites externe malveillantes pour la suppresion ou modifications des données-->
                                        @method('DELETE')
                                        <!-- declencheur de ce methode dans le controlleur -->
                                        <!-- public function destroy($num)
{
    $artist = Artist::findOrFail($num);
    $artist->delete();

    return redirect()->route('artists.index')->with('success', 'Artiste supprimé avec succès');
} -->

                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Voulez-vous vraiment supprimer cet artiste ?');"><img
                                                src="{{ asset('icons/delete_24dp_E3E3E3_FILL0_wght400_GRAD0_opsz24.png') }}"
                                                alt="Delete" width="16" height="16"
                                                alt=""></button>
                                    </form>
                                </td>

        </tr>
        
        @endforeach
    </tbody>
</table>

<div style="margin-top: 15px; display:flex; align-items:center; gap:10px;">
       
       {{-- pagination --}}
    {{ $artists->links() }}

    <!-- Bouton d'export CSV des oeuvres pour cette catégorie -->
    <a href="{{ route('oeuvres.export', $categorie) }}" style="padding:8px 12px; background:#10B981; color:white; border-radius:6px; text-decoration:none; margin-left:8px;">Exporter oeuvres (CSV)</a>

        <form onsubmit="goToPage2(event)" style="display:flex; align-items:center; gap:5px;">
            <label>Aller à la page :</label>
            <input type="number" id="pageInput2" min="1" max="{{ $artists->lastPage() }}" style="width:60px; padding:3px;">
            <button type="submit" style="padding:5px;">OK</button>
        </form>
    </div>

@else
<p>Aucun artiste dans cette catégorie.</p>
@endif

</div>

<style>
.categorie-card:hover {
    background-color: #f0f0f0;
    transform: scale(1.05);
}
</style>

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

        const addBtn = document.getElementById('addBtn');
        const addForm = document.getElementById('addForm');
        const artistTable = document.getElementById('artistTable');
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearch');
        const rows = document.querySelectorAll('#artistTable tbody tr');

        // Afficher le formulaire et cacher le tableau
        addBtn.addEventListener('click', function() {
            if (addForm.style.display === 'none') {
                addForm.style.display = 'block';
                if (artistTable) artistTable.style.display = 'none';
            } else {
                addForm.style.display = 'none';
                if (artistTable) artistTable.style.display = 'table';
            }
        });

        // Réinitialiser la recherche
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            rows.forEach(row => row.style.display = '');
            searchInput.focus();
            window.location.reload();
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

