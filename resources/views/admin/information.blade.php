<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informations du compte</title>
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
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
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
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
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
    box-shadow: 0 6px 16px rgba(0,0,0,0.13);
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
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

/* Vague bleue au hover */
.link a::after {
    content: "";
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: rgba(37, 99, 235, 0.1);
    transition: left 0.4s ease;
}
.link a:hover::after {
    left: 0;
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
            <li><a href="/artists" ><img src="{{ asset('icons/artist_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Artistes" width="24" height="24"> Artistes</a></li>
            <li><a href="/oeuvres"><img src="{{ asset('icons/speech_to_text_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Oeuvres" width="24" height="24">Oeuvres</a></li>
            <li><a href="/admin"  class="active"><img src="{{ asset('icons/admin_panel_settings_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Administration" width="24" height="24">Administration</a></li>
            <li><a href="/logout" class="logout" id="logoutLink"><img src="{{ asset('icons/logout_24dp_D9D9D9_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Logout" width="24" height="24">Se déconnecter</a></li>

        </ul>
            {{-- <li><a href="/logout" class="logout" ><img src="{{ asset('icons/se-deconnecter.png') }}" alt="Dashboard" style="width: 20px; margin-right:8px;">Se déconnecter</a></li> --}}

        
    </nav>



<div class="main-conteneur">
 <h1>Vos informations à propos de ce compte</h1>



 <div class="info-card">
            <h3>Détails de votre compte</h3>
           
            <table>
                <tr>
                    <th>ID Administrateur :</th>
                    <td>{{ $admin->id }}</td>
                </tr>
                <tr>
                    <th>Nom d’utilisateur :</th>
                    <td>{{ $admin->username }}</td>
                </tr>
                <tr>
                    <th>Email :</th>
                    <td>{{ $admin->email}}</td>
                </tr>
                <tr>
                    <th>Adresse :</th>
                    <td>{{ $admin->adresse }}</td>
                </tr>
                <tr>
                    <th>Telephone :</th>
                    <td>{{ $admin->telephone }}</td>
                </tr>
                
            </table>
        </div>




</div>
<aside class="silde-in-right">
  <img src="../images/logo3.png" alt="">
    <h2>Votre centre d'Administration</h2>
    <h3 class="username">{{ $username }}</h3>
        <div class="link">
            <ul>
                <li>
                    <a href="{{ route('admin.gestion') }}">
                        Gestion de mon compte
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
        if(e.target == modal) modal.style.display = 'none';
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
            }, { once: true });
        });
    }
});
</script>
</body>
</html>