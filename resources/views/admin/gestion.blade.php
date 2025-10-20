<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion du compte</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('icons/bootstrap-icons.css') }}">
    <style>
        /* Aside modernisé avec slide in/out */
        aside {
            height: 95vh;
            background: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
            padding: 30px;
            gap: 20px;
            width: 350px;
            border-radius: 30px 0 0 30px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.13);
            text-align: center;

            /* Animation d’entrée */
            opacity: 0;
            transform: translateX(100%);
            animation: slideInRight 0.8s ease forwards;
        }

        @keyframes slideInRight {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
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
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        a {
            display: flex;
            align-items: center;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.13);
            color: var(--color-info-dark);
            gap: 1rem;
            text-decoration: none;
            transition: all 300ms ease;
            position: relative;
            overflow: hidden;
        }

        a:hover {
            background-color: rgb(211, 207, 207);
            color: #111827;
            transform: translateX(5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* Vague bleue au hover */
        a::after {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(37, 99, 235, 0.1);
            transition: left 0.4s ease;
        }

        a:hover::after {
            left: 0;
        }


        .gestion-container {
            margin: 50px auto;
            max-width: 800px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        

        .sub-choice {
            margin-top: 20px;
        }
        .link{
            width: 300px;
            margin: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        form {
            margin-top: 20px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button[type="submit"],
        .btn-ok {
            background: #16a34a;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        button[type="submit"]:hover,
        .btn-ok:hover {
            background: #15803d;
        }

        .danger-zone {
            border: 2px solid red;
            border-radius: 10px;
            padding: 25px;
            margin-top: 25px;
        }

        .danger-zone button {
            background: red;
        }

        .hidden {
            display: none;
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

                <li><a href="/dashboard"><img
                            src="{{ asset('icons/monitoring_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}"
                            alt="Dashboard" width="24" height="24" alt=""> Dashboard</a></li>
                <li><a href="/artists"><img src="{{ asset('icons/artist_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}"
                            alt="Artistes" width="24" height="24"> Artistes</a></li>
                <li><a href="/oeuvres"><img
                            src="{{ asset('icons/speech_to_text_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}"
                            alt="Oeuvres" width="24" height="24">Oeuvres</a></li>
                <li><a href="/admin" class="active"><img
                            src="{{ asset('icons/admin_panel_settings_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.png') }}"
                            alt="Administration" width="24" height="24">Administration</a></li>
                <li><a href="/logout" class="logout" id="logoutLink"><img
                            src="{{ asset('icons/logout_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Logout"
                            width="24" height="24">Se déconnecter</a></li>

            </ul>
        </nav>



        <div class="main-conteneur">
            <h1>Votre centre de contrôle de vos informations </h1>






            <div class="gestion-container">
                <h2>Gestion du compte</h2>

                {{-- ✅ Messages de succès ou d’erreur --}}
                @if (session('success'))
                    <p style="color: green;">{{ session('success') }}</p>
                @endif
                @if (session('error'))
                    <p style="color: red;">{{ session('error') }}</p>
                @endif

                {{-- === PREMIER CHOIX : MODIFICATION OU SUPPRESSION === --}}
                <div id="firstChoice">

                    <div class="link" style="width: 50%; margin: auto; padding: 30px;">
                        <ul>
                            <li>
                                <a id="btnModify"> {{-- ETO NO MANAMBOTRA --}}
                                    Modification des informations
                                </a>
                            </li>


                            <li>
                                <a id="btnDelete"> {{-- ETO NO MANAMBOTRA --}}
                                    Suppression du compte
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- === SOUS-CHOIX : MODIFIER LE PROFIL OU MOT DE PASSE === --}}
                <div id="modifyChoice" class="sub-choice hidden">
                    <div class="link">
                        <a class="btn-choice" id="btnProfil">Modifier le profil</a>
                        <a class="btn-choice" id="btnPassword">Modifier le mot de passe</a>
                    </div>
                </div>

                {{-- === FORMULAIRE : MODIFIER LE PROFIL === --}}
                <form id="formProfil" action="{{ route('admin.updateInfo') }}" method="POST" class="hidden">
                    @csrf
                    <div class="form-group">
                        <label>Nom d'utilisateur</label>
                        <input type="text" name="username" value="{{ $admin->username }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $admin->email }}" required>
                    </div>
                    <div class="form-group">
                        <label>Adresse</label>
                        <input type="text" name="adresse" value="{{ $admin->adresse }}" required>
                    </div>
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="text" name="telephone" value="{{ $admin->telephone }}" required>
                    </div>

                    <button type="button" class="button" id="okProfil"><span class="button-content">OK</span></button>

                    <div id="confirmProfil" class="hidden">
                        <div class="form-group">
                            <label>Mot de passe actuel</label>
                            <input type="password" name="current_password" required>
                        </div>
                        <button type="submit">Confirmer la modification</button>
                    </div>
                </form>

                {{-- === FORMULAIRE : MODIFIER LE MOT DE PASSE === --}}
                <!-- 🔹 FORMULAIRE : MODIFIER LE MOT DE PASSE -->
                <form id="formPassword" action="{{ route('admin.updatePassword') }}" method="POST" class="hidden">
                    @csrf
                    <div class="form-group">
                        <label>Ancien mot de passe</label>
                        <input type="password" name="old_password" required>
                    </div>
                    <div class="form-group">
                        <label>Nouveau mot de passe</label>
                        <input type="password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label>Confirmer le nouveau mot de passe</label>
                        <input type="password" name="new_password_confirmation" required>
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <button type="submit">Modifier le mot de passe</button>
                        <a href="#" id="forgotPasswordLink"
                            style="color:#2563eb; text-decoration:underline; font-size:0.9rem;">
                            Mot de passe oublié ?
                        </a>
                    </div>

                    <p id="forgotMessage" class="hidden" style="color:red; font-weight:500; margin-top:10px;">
                         Modification réservée à Mr Mamy ou au Directeur.
                    </p>
                </form>


                {{-- === FORMULAIRE : SUPPRESSION DU COMPTE === --}}
                <div id="deleteAccount" class="danger-zone hidden">
                    <h3>Supprimer le compte</h3>
                    <p style="color:red;">Cette action est irréversible. Veuillez confirmer votre mot de passe.</p>
                    <form action="{{ route('admin.deleteAccount') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Mot de passe actuel</label>
                            <input type="password" name="password" required>
                        </div>
                        <button type="submit">Supprimer mon compte</button>
                    </form>
                </div>
            </div>



            <script>
                const btnModify = document.getElementById('btnModify');
                const btnDelete = document.getElementById('btnDelete');
                const modifyChoice = document.getElementById('modifyChoice');
                const deleteAccount = document.getElementById('deleteAccount');
                const firstChoice = document.getElementById('firstChoice');

                const btnProfil = document.getElementById('btnProfil');
                const btnPassword = document.getElementById('btnPassword');
                const formProfil = document.getElementById('formProfil');
                const formPassword = document.getElementById('formPassword');
                const okProfil = document.getElementById('okProfil');
                const confirmProfil = document.getElementById('confirmProfil');

                // 🔹 Étape 1 : Choisir Modification ou Suppression
                btnModify.addEventListener('click', () => {
                    firstChoice.classList.add('hidden');
                    modifyChoice.classList.remove('hidden');
                });

                btnDelete.addEventListener('click', () => {
                    firstChoice.classList.add('hidden');
                    deleteAccount.classList.remove('hidden');
                });

                // 🔹 Étape 2 : Choisir quel type de modification
                btnProfil.addEventListener('click', () => {
                    modifyChoice.classList.add('hidden');
                    formProfil.classList.remove('hidden');
                });

                btnPassword.addEventListener('click', () => {
                    modifyChoice.classList.add('hidden');
                    formPassword.classList.remove('hidden');
                });

                // 🔹 Étape 3 : Afficher la confirmation du mot de passe après “OK”
                okProfil.addEventListener('click', () => {
                    okProfil.style.display = 'none';
                    confirmProfil.classList.remove('hidden');
                });
                // 🔹 Lien "mot de passe oublié"
                const forgotLink = document.getElementById('forgotPasswordLink');
                const forgotMessage = document.getElementById('forgotMessage');

                forgotLink.addEventListener('click', (e) => {
                    e.preventDefault();
                    forgotMessage.classList.toggle('hidden');
                });
                const modal = document.getElementById('adminModal');
                const openBtn = document.getElementById('openModal');
                const closeBtn = document.getElementById('closeModal');
                //     const btnModify = document.getElementById('btnModify');
                //     const btnDelete = document.getElementById('btnDelete');
                //     const modifyChoice = document.getElementById('modifyChoice');
                //     const deleteAccount = document.getElementById('deleteAccount');
                //     const firstChoice = document.getElementById('firstChoice');
                //     const btnProfil = document.getElementById('btnProfil');
                //     const btnPassword = document.getElementById('btnPassword');
                //     const formProfil = document.getElementById('formProfil');
                //     const formPassword = document.getElementById('formPassword');
                //     const okProfil = document.getElementById('okProfil');
                //     const confirmProfil = document.getElementById('confirmProfil');




                openBtn.addEventListener('click', () => {
                    modal.style.display = 'flex';
                });

                closeBtn.addEventListener('click', () => {
                    modal.style.display = 'none';
                });

                window.addEventListener('click', (e) => {
                    if (e.target == modal) modal.style.display = 'none';
                });

                document.addEventListener("DOMContentLoaded", () => {
                    const aside = document.querySelector("aside");
                    const logoutLink = document.getElementById("logoutLink");

                    if (logoutLink && aside) {
                        logoutLink.addEventListener("click", function(e) {
                            e.preventDefault(); // bloque la redirection immédiate
                            aside.classList.add("exit"); // lance l’anim de sortie

                            // quand l'anim est terminée → redirection
                            aside.addEventListener("animationend", () => {
                                window.location.href = logoutLink.getAttribute("href");
                            }, {
                                once: true
                            });
                        });
                    }
                });
            </script>
        </div>
        <aside class="silde-in-right">
            <img src="../images/logo3.png" alt="">
            <h2>Votre centre d'Administration</h2>
            <h3 class="username">{{ $username }}</h3>
            <div class="link">
                <ul>
                    <li>
                        <a href="{{ route('admin.information') }}">
                            Mes informations
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.index') }}">
                            Retour
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

    </div>
</body>

</html>
