<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<body>
    
<style>
.artist-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.artist-table th, .artist-table td {
    border: 1px solid #ccc;
    padding: 8px 12px;
    text-align: left;
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
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    z-index: 9999;
  }

</style>
<div class="container">
<nav class="sidebar">
        <div class="logo">
            <h2>Office Malagasy du Droit d'Auteur</h2>
            <h3>O M D A</h3>
        </div>
        <ul>
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/artists">Gestion des artistes</a></li>
            <li><a href="/oeuvres" class="active">Gestion des œuvres</a></li>
            <li><a href="/admin">Administration</a></li>
            <li><a href="/calendrier">Calendrier et Evenements</a></li>
            <li><a href="/logout" class="logout">Se déconnecter</a></li>
        </ul>
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
        <h2>Liste des oeuvres</h2>
        <div style="display: flex; justify-content: flex-end; margin-bottom: 10px; position: relative; width: 220px;">
        
      <div style="display: flex; align-items:center; justify-content: space-between;">

    <div style="display: flex; gap: 10px; align-items: center;">

        <!-- Recherche -->
        <form method="GET" action="{{ route('oeuvres.byCategory', $categorie) }}" style="position: relative;">
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
<h1>Œuvres - {{ $categorie }}</h1>



<div style="margin-top: 15px; display:flex; align-items:center; gap:10px;">
       
       {{-- pagination --}}
        {{ $oeuvres->links() }}

        <form onsubmit="goToPage2(event)" style="display:flex; align-items:center; gap:5px;">
            <label>Aller à la page :</label>
            <input type="number" id="pageInput2" min="1" max="{{ $oeuvres->lastPage() }}" style="width:60px; padding:3px;">
            <button type="submit" style="padding:5px;">OK</button>
        </form>
    </div>

@if($oeuvres->count() > 0)
<table class="artist-table">
    <thead>
        <tr>
            <th>Code titre</th>
            <th>Titre</th>
            <th>Catégories</th>
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
            <td>{{ $oeuvre->categorie }}</td>
            @if ($oeuvre->categorie === 'LYR')
                <td>{{ $oeuvre->nom }}</td>
                <td>{{ $oeuvre->pseudo }}</td>
                <td>{{ $oeuvre->groupe}}</td>
                <td>{{ $oeuvre->qualite }}</td>
                <td>{{ $oeuvre->part }}</td>
                <td>{{ $oeuvre->droit }}</td>
                <td>{{ $oeuvre->Hologramme }}</td>
            @else
                <td>{{ $oeuvre->auteur }}</td>
                <td>{{ $oeuvre->part}}</td>
            @endif
            <td>{{ $oeuvre->date_depot }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
 <div style="margin-top: 15px; display:flex; align-items:center; gap:10px;">
       
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
    document.addEventListener('DOMContentLoaded', function () {
  // navigation par clic sur la ligne, sauf si on clique un bouton/lien/champ
  document.querySelectorAll('#artistTable tbody tr').forEach(tr => {
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
    if(page) {
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);
        window.location.href = url.toString();
    }
    
}
 function goToPage2(e) {
    e.preventDefault();
    const page = document.getElementById('pageInput2').value;
    if(page) {
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);
        window.location.href = url.toString();
    }
    
}


</script>


</body>