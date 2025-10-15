<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'artiste</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .artist-details {
            min-width: 700px;
            max-width: 800px;
            margin: 40px 50px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-height: 600px;
        }
        .artist-details h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .artist-details p {
            margin: 8px 0;
            font-size: 16px;
        }
        .back-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 15px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .back-btn:hover {
            background: #0056b3;
        }
        /* From Uiverse.io by Madflows */ 
.button {
    margin: 20px auto;
  position: relative;
  overflow: hidden;
  height: 3rem;
  padding: 0 2rem;
  border-radius: 1.5rem;
  background: #3d3a4e;
  background-size: 400%;
  color: #fff;
  border: none;
  cursor: pointer;
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
  background: linear-gradient(
    82.3deg,
    rgba(150, 93, 233, 1) 10.8%,
    rgba(99, 88, 238, 1) 94.3%
  );
  transition: all 0.475s;
}
    </style>
<script src="{{ asset('js/xlsx.full.min.js') }}"></script>
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
    
            <li><a href="/dashboard"><img src="{{ asset('icons/monitoring_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Dashboard" width="24" height="24" alt=""> Dashboard</a></li>
            <li><a href="/artists" class="active"><img src="{{ asset('icons/artist_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Artistes" width="24" height="24"> Artistes</a></li>
            <li><a href="/oeuvres"><img src="{{ asset('icons/speech_to_text_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Oeuvres" width="24" height="24">Oeuvres</a></li>
            <li><a href="/admin"  ><img src="{{ asset('icons/admin_panel_settings_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Administration" width="24" height="24">Administration</a></li>
            <li><a href="/logout" class="logout" id="logoutLink"><img src="{{ asset('icons/logout_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Logout" width="24" height="24">Se déconnecter</a></li>

        </ul>
    </nav>
    <div class="main-conteneur">
<div class="information">
    <div>
    <div class="artist-details"  id="artist-info">
        <h2>{{ $artist->nom }} ({{ $artist->pseudo }})</h2>
        <p><strong>Groupe :</strong> {{ $artist->groupes }}</p>
        <p><strong>Numéro OMDA :</strong> {{ $artist->num }}</p>
        <p><strong>Catégorie :</strong> {{ $artist->categorie }}</p>
        <p><strong>Numéro Wipo :</strong> {{ $artist->num_wipo }}</p>
        <p><strong>Date d’adhésion :</strong> {{ $artist->date_adh }}</p>
        <p><strong>Contact :</strong> {{ $artist->contact }}</p>
        <p><strong>Email :</strong> {{ $artist->email }}</p>
        <p><strong>Adresse :</strong> {{ $artist->adresse }}</p>
        <p><strong>Province :</strong> {{ $artist->province }}</p>
        <p><strong>Sexe :</strong> {{ $artist->sexe }}</p>
        <p><strong>CIN :</strong> {{ $artist->cin }}</p>
        <p><strong>Date de naissance :</strong> {{ $artist->date_naissance }}</p>
        <p><strong>Pension :</strong> {{ $artist->pension }}</p>
        <p><strong>Statut :</strong> {{ $artist->statut }}</p>
        <p><strong>Hologramme :</strong> {{ $artist->hologramme }}</p>

    </div>
    <div style="margin-top:20px; text-align:center;">
    <button onclick="printArtist()" 
            style="padding:10px 20px; background:#3498db; color:white; border:none; cursor:pointer; border-radius:5px;">
        🖨️ Imprimer les informations
    </button>
    </div>

    </div>


    
        <div class="oeuvre">
<div>
    
</div>

        <h3>Œuvres</h3>
   <div>
<div style="margin-bottom:20px;">
        <!-- Bouton Ajouter une œuvre -->
        <a href="{{ route('oeuvres.create') }}?type={{ $type }}&num={{ $artist->num }}" 
           class="btn btn-primary" 
           style="padding:8px 15px; border-radius:5px; text-decoration:none;">
           Ajouter une œuvre
        </a>
        
@if($oeuvres->count() > 0)
   <table id="oeuvresTable" border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Code</th>
                <th>Titre</th>
                <th>Date de depot</th>
                <th>part</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($oeuvres as $oeuvre)
                <tr>
                    <td>{{ $oeuvre->code_titre }}</td>
                    <td>{{ $oeuvre->titre }}</td>
                    <td>{{ $oeuvre->date_depot }}</td>
                        <td>{{ $oeuvre->part }}</td>
                        <td>
                            <!-- modif -->
                            <a href="{{ route('oeuvres.edit', $oeuvre->code_titre) }}" style="padding:5px 10px; background:#007bff; color:white; border-radius:5px; text-decoration:none;">Modifier</a>
                            <!-- suppr -->
                            <form action="{{ route('oeuvres.destroy', $oeuvre->code_titre) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                               <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cet oeuvre ?');">Supprimer</button>
                        </form>
                        </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Aucune œuvre trouvée.</p>
@endif
        <button class="button" id="exportExcelBtn"><span class="button-content">Exporter vers Excel </span></button>


        <script>
    function printArtist() {
        let content = document.getElementById('artist-info').innerHTML;
        let win = window.open('', '', 'height=700,width=900');
        win.document.write('<html><head><title>Fiche Artiste</title>');
        win.document.write('<style>body{font-family:Arial; padding:20px;} strong{color:#333;}</style>');
        win.document.write('</head><body>');
        win.document.write(content);
        win.document.write('</body></html>');
        win.document.close();
        win.print();
        }


     document.getElementById('exportExcelBtn').addEventListener('click', function() {
    // Récupérer le tableau des œuvres
    var table = document.querySelector('.oeuvre table');
    var workbook = XLSX.utils.table_to_book(table, {sheet:"Oeuvres"});

    // Récupérer le nom de l'artiste depuis Blade
    var artistName = "{{ $artist->nom }}".replace(/\s+/g, '_'); // remplace les espaces par des "_"
    var filename = artistName + ".xlsx";

    // Générer le fichier Excel
    XLSX.writeFile(workbook, filename);
});
    </script>
</div>
</div>
</div>
</div>
</body>
</html>
