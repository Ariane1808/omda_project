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

         .link a {
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

         .link a:hover {
             background-color: rgb(211, 207, 207);
             color: #111827;
             transform: translateX(5px);
             box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
         }

         /* Vague bleue au hover */
         .link a::after {
             content: "";
             position: absolute;
             top: 0;
             left: -100%;
             width: 100%;
             height: 100%;
             background: rgba(37, 99, 235, 0.1);
             transition: left 0.4s ease;
         }
           form{
            width: fit-content;
            margin: 50px auto;
            padding:30px;
            border-radius:30px; 
            background:#fff;
            display: flex;
            flex-direction: column;
            gap: 20px;
             box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        form input {

            border: 1px solid grey;
            border-radius: 20px;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-size: 0.9rem;
            background: #f9fafb;
            transition: border 0.3s, background 0.3s;
        }
        form input:focus,
        form select:focus {
    border-color: #2563eb;
    background: #ffffff;
    outline: none;
}
         .link a:hover::after {
             left: 0;
         }
         .bouton{
            display: flex;
            gap:20px;
         }


.button:hover {
        transform: translateY(-2px);
  box-shadow: 0 6px 14px rgba(29, 78, 216, 0.4);
    }

         .button {
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
   background: #1e3a8a;
  color: #fff;
  box-shadow: 0 4px 10px rgba(30, 58, 138, 0.3);
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

                 <li><a href="/dashboard"><img src="{{ asset('icons/monitoring_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Dashboard" width="24" height="24" alt=""> Dashboard</a></li>
                 <li><a href="/artists"><img src="{{ asset('icons/artist_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Artistes" width="24" height="24"> Artistes</a></li>
                 <li><a href="/oeuvres"><img src="{{ asset('icons/speech_to_text_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Oeuvres" width="24" height="24">Oeuvres</a></li>
                 <li><a href="/admin" class="active"><img src="{{ asset('icons/admin_panel_settings_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Administration" width="24" height="24">Administration</a></li>
                 <li><a href="/logout" class="logout" id="logoutLink"><img src="{{ asset('icons/logout_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Logout" width="24" height="24">Se déconnecter</a></li> 
            </ul>
         </nav>



         <div class="main-conteneur">
             <h1>Modification des informations </h1>
             <form action="{{ route('admin.update', $admin->id) }}" method="POST">
                 @csrf
                 @method('PUT')
                 <input type="text" name="username" placeholder="Nom d’utilisateur" required><br>
                 <input type="email" name="email" placeholder="Email" required><br>
                 <input type="text" name="adresse" placeholder="Adresse" required><br>
                 <input type="text" name="telephone" placeholder="Numéro" required><br>
                 <input type="password" name="password" placeholder="Mot de passe" required><br>
                 <div class="bouton">
                    <button type="submit" class="btn btn-save">Enregistrer les modifications</button>
        <a href="{{ route('admin.index') }}" class="btn btn-cancel">Annuler</a>
                 </div>
            </form>




             <script>
                 const modal = document.getElementById('adminModal');
                 const openBtn = document.getElementById('openModal');
                 const closeBtn = document.getElementById('closeModal');

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
             <img src="./../../images/logo3.png" alt="">
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
