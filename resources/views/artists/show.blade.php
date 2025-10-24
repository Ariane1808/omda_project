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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
            background: #c4c2cf;
            background-size: 400%;
            color: #1f1f1f;
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
        
        a.btn{
            color: #0f0f0f;
        }
        .button:hover{
            a.btn{
                color:white;
            }
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
        <div class="main-conteneur">
            <div class="information">
                <div>
                    <div class="artist-details" id="artist-info">
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
                            <button class="button" id="addBtn">
                                <a href="{{ route('oeuvres.create') }}?type={{ $type }}&num={{ $artist->num }}"class="btn btn-primary button-content"><span class="button-content">Ajouter une œuvre</span></a>
                            </button>

                            @if ($oeuvres->count() > 0)
                                <table id="oeuvresTable" border="1" cellpadding="8" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Titre</th>
                                            <th>Date de depot</th>
                                              @foreach ($oeuvres as $oeuvre)
                                            @if ($oeuvre->categorie === 'LYR')
                                                <th>Qualité</th>
                                                <th>Droit</th>
                                                @break
                                            @endif
                                            @endforeach
                                            <th>part</th>
                                            <th>Action</th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($oeuvres as $oeuvre)
                                            <tr>
                                                <td>{{ $oeuvre->code_titre }}</td>
                                                <td>{{ $oeuvre->titre }}</td>
                                                <td>{{ $oeuvre->date_depot }}</td>
                                                
                                                @if ($oeuvre->categorie === 'LYR')
                                                 <td>{{ $oeuvre->qualite }}</td>
                                                <td>{{ $oeuvre->droit }}</td>
                                                @endif
                                                
                                                <td>{{ $oeuvre->part }}</td>
                                               
                                                <td>
                                                    <!-- modif -->
                                                    <a href="{{ route('oeuvres.edit', $oeuvre->code_titre) }}"
                                                        style="padding:5px 10px; background:#007bff; color:white; border-radius:5px; text-decoration:none;"><img
                                                            src="{{ asset('icons/edit_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.png') }}"
                                                            alt="Edit" width="24" height="24"
                                                            alt=""></a>
                                                    <!-- suppr -->
                                                    <form action="{{ route('oeuvres.destroy', $oeuvre->code_titre) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Voulez-vous vraiment supprimer cet oeuvre ?');"><img
                                                                src="{{ asset('icons/delete_24dp_E3E3E3_FILL0_wght400_GRAD0_opsz24.png') }}"
                                                                alt="Delete" width="24" height="24"
                                                                alt=""></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>Aucune œuvre trouvée.</p>
                            @endif
                            <button class="button" id="exportExcelBtn"><span class="button-content">Exporter vers Excel
                                </span></button>


                            <script>
 function printArtist() {
    let content = document.getElementById('artist-info').innerHTML;
    let win = window.open('', '', 'height=950,width=750');

    win.document.write('<html><head><title>Fiche Artiste OMDA</title>');
    win.document.write(`
        <style>
            body {
                font-family: 'Segoe UI', Arial, sans-serif;
                background: #fff;
                padding: 0;
                margin: 0;
                color: #333;
            }

            .fiche-container {
                width: 90%;
                margin: 30px auto;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                border: 1px solid #ddd;
            }

            /* Bandeau supérieur */
            .fiche-header {
                background-color: #3660a8;
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 20px;
                position: relative;
            }

            .logo-print img {
                height: 70px;
            }

            .artist-title {
                font-size: 22px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 1px;
                flex: 1;
                text-align: center;
            }

            /* Photo stylisée */
            .photo-id {
                width: 130px;
                height: 160px;
                border: 3px solid #fff;
                border-radius: 10px;
                overflow: hidden;
                background: #f1f1f1;
                text-align: center;
                line-height: 160px;
                color: #666;
                font-size: 13px;
                position: absolute;
                bottom: -80px;
                right: 30px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            }

            /* Bloc d'informations */
            .artist-info {
                background: #f9f9fb;
                padding: 100px 30px 30px 30px;
            }

            .artist-info p {
                margin: 8px 0;
                font-size: 15px;
                line-height: 1.5;
            }

            .artist-info p strong {
                color: #3660a8;
                display: inline-block;
                width: 200px;
            }

            .footer {
                text-align: center;
                margin-top: 25px;
                font-size: 12px;
                color: #777;
            }
                @media print {
    body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
}

        </style>
    `);
    win.document.write('</head><body>');

    // Contenu HTML stylisé
    win.document.write(`
        <div class="fiche-container">
            <div class="fiche-header">
                <div class="logo-print">
                    <img src="${window.location.origin}/images/logo.jpg" alt="OMDA Logo">
                </div>
                <div class="artist-title">Fiche d'Artiste</div>
                <div class="photo-id">Photo d'identité</div>
            </div>

            <div class="artist-info">
                ${content}
            </div>

            <div class="footer">
                © OMDA - Office Malgache du Droit d’Auteur
            </div>
        </div>
    `);

    win.document.write('</body></html>');
    win.document.close();

    win.onload = function () {
        win.print();
    };
}





                                document.getElementById('exportExcelBtn').addEventListener('click', function() {
                                    // Récupérer le tableau des œuvres
                                    var table = document.querySelector('.oeuvre table');
                                    var workbook = XLSX.utils.table_to_book(table, {
                                        sheet: "Oeuvres"
                                    });

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
