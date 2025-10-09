
<style>
    .work-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.work-card {
    width: 250px;
    padding: 15px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    transition: transform 0.3s;
    cursor: pointer;
}

.work-card:hover {
    transform: scale(1.05);
}

</style>

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<body>

<div class="container">
   <nav class="sidebar">
        <div class="logo">
        <h2>Office Malagasy du Droit d'Auteur</h2>
        <h3>O M D A</h3>
        </div>
        <ul class="onglets">
         
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/artists">Gestion des artistes</a></li>
            <li><a href="/works">Gestion des œuvres</a></li>
            
            <li><a href="/logout">Se déconnecter</a></li>
            
        </ul>
    </nav>
 <div class="main-conteneur">



<h2>Liste des oeuvres</h2>
<div style="display: flex; justify-content: flex-end; margin-bottom: 10px; position: relative; width: 220px;">
    <input type="text" id="searchInput" placeholder="Rechercher..." style="padding:5px 10px; width:100%;">
    <span id="clearSearch" style="position:absolute; right:5px; top:50%; transform:translateY(-50%); cursor:pointer; font-weight:bold; color:#888;">&times;</span>
</div>
@if($work->count() > 0)
    <table class="oeuvre-table" id="oeuvreTable">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Type :</th>
                <th>Date de sortie</th>
             
            </tr>
        </thead>
        <tbody>
            @foreach($work as $work)
                <td>{{ $work->titre }}</td>
                <td>{{ $work->type }}</td>
                <td>{{ $work->annee }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Aucune oeuvre trouvé.</p>
@endif

 </div>
</div>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearSearch');
    const rows = document.querySelectorAll('#oeuvreTable tbody tr');

    // Filtrage en temps réel
    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Réinitialiser la recherche
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        rows.forEach(row => row.style.display = '');
        searchInput.focus();
    });
});
</script>
</body>