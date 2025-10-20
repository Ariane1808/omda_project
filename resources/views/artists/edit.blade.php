@include('includes.loader')


<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    /* ----- FORMULAIRE ----- */
    .main-conteneur form {
        background: #ffffff;
        border-radius: 12px;
        padding: 25px 30px;
        max-width: 700px;
        margin: auto;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* Champs */
    .main-conteneur form div {
        margin-bottom: 12px;
        display: flex;
        flex-direction: column;
    }

    .main-conteneur form label {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: #1f2937;
    }

    .main-conteneur form input[type="text"],
    .main-conteneur form input[type="date"],
    .main-conteneur form select {
        padding: 8px 10px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        font-size: 0.9rem;
        background: #f9fafb;
        transition: border 0.3s, background 0.3s;
    }

    .main-conteneur form input:focus,
    .main-conteneur form select:focus {
        border-color: #2563eb;
        background: #ffffff;
        outline: none;
    }

    /* Radios */
    .main-conteneur form input[type="radio"] {
        margin-right: 5px;
        transform: scale(0.9);
    }

    .main-conteneur form label[for="homme"],
    .main-conteneur form label[for="femme"] {
        font-weight: 500;
        margin-right: 15px;
        display: inline-flex;
        align-items: center;
    }

    /* ----- BOUTONS STYLE UIVERSE ----- */
    .main-conteneur form .btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 28px;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 10px;
        cursor: pointer;
        border: none;
        text-decoration: none;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.25s ease;
    }

    /* Effet vague animé Uiverse */
    .main-conteneur form .btn::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 200%;
        height: 100%;
        background: rgba(255, 255, 255, 0.15);
        transform: skewX(-20deg);
        transition: left 0.5s ease;
    }

    .main-conteneur form .btn:hover::before {
        left: 100%;
    }

    /* Bouton Enregistrer */
    .main-conteneur form .btn-save {
        background: #1e3a8a;
        color: #fff;
        box-shadow: 0 4px 10px rgba(30, 58, 138, 0.3);
    }

    .main-conteneur form .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(29, 78, 216, 0.4);
    }

    /* Bouton Annuler */
    .main-conteneur form .btn-cancel {
        background: #6b7280;
        color: #fff;
        box-shadow: 0 4px 10px rgba(107, 114, 128, 0.3);
    }

    .main-conteneur form .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(75, 85, 99, 0.4);
    }

    /* ----- RESPONSIVE ----- */
    @media (max-width: 768px) {
        .main-conteneur {
            margin-left: 0;
            padding: 20px;
        }

        .main-conteneur form {
            padding: 20px;
            max-width: 100%;
        }
    }
</style>

<nav class="sidebar">
    <div class="logo">
        <h2>Office Malagasy du Droit d'Auteur</h2>
        <h3>O M D A</h3>
    </div>
    <ul class="onglets">

        <li><a href="/dashboard"><img src="{{ asset('icons/monitoring_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}"
                    alt="Dashboard" width="24" height="24" alt=""> Dashboard</a></li>
        <li><a href="/artists" class="active"><img
                    src="{{ asset('icons/artist_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Artistes"
                    width="24" height="24"> Artistes</a></li>
        <li><a href="/oeuvres"><img src="{{ asset('icons/speech_to_text_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}"
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

    <form action="{{ route('artists.update', $artist->num) }}" method="POST">
        @csrf
        @method('PUT') <!-- important pour la mise à jour -->

        <div style="margin-bottom: 10px;">
            <label>Num Wipo :</label>
            <input type="text" name="num_wipo" value="{{ $artist->num_wipo }}" required>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Nom :</label>
            <input type="text" name="nom" value="{{ $artist->nom }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Catégories :</label>
            <input type="text" name="categories" value="{{ $artist->categorie }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Pseudo :</label>
            <input type="text" name="pseudo" value="{{ $artist->pseudo }}" required>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Groupe :</label>
            <input type="text" name="groupes" value="{{ $artist->groupes }}" required>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Date de naissance :</label>
            <input type="date" name="date_naissance" value="{{ $artist->date_naissance }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Contact :</label>
            <input type="text" name="contact" value="{{ $artist->contact }}" required>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Email :</label>
            <input type="text" name="email" value="{{ $artist->email }}" required>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Adresse :</label>
            <input type="text" name="adresse" value="{{ $artist->adresse }}" required>
        </div>
        <div style="margin-bottom:10px;">
            <label>Province:</label>
            <select name="province" id="">
                <option value="ANTANANARIVO">ANTANANARIVO</option>
                <option value="TOAMASINA">TOAMASINA</option>
                <option value="ANTSIRANANA">ANTSIRANANA</option>
                <option value="MAHAJANGA">MAHAJANGA</option>
                <option value="FIANARANTSOA">FIANARANTSOA</option>
                <option value="TOLIARA">TOLIARA</option>
            </select>
        </div>
        <div style="margin-bottom:5px;">
            <!-- <input type="text" name="sexe" required> -->
            <label>Sexe :</label>
            <input type="radio" name="sexe" value="H" id="homme" required>
            <label for="homme">Homme</label>

            <input type="radio" name="sexe" value="F" id="femme">
            <label for="femme">Femme</label>

        </div>
        <div style="margin-bottom: 10px;">
            <label>Pension :</label>
            <input type="text" name="pension" value="{{ $artist->pension }}" required>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Statut :</label>
            <input type="text" name="statut" value="{{ $artist->statut }}" required>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Hologramme :</label>
            <input type="text" name="hologramme" value="{{ $artist->hologramme }}" required>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Date d'adhésion :</label>
            <input type="date" name="date_adh" value="{{ $artist->date_adh }}" required>
        </div>

        <button type="submit" class="btn btn-save">
            Enregistrer les modifications
        </button>

        <a href="{{ route('artists.byCategory', $artist->categorie) }}" class="btn btn-cancel">Annuler</a>
    </form>
</div>
</div>
</div>
