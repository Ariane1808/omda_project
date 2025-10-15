<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administration</title>
     <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
     <link rel="stylesheet" href="{{ asset('icons/bootstrap-icons.css') }}">
      {{-- <script src="{{ asset('js/index.global.min.js') }}"></script> --}}

    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
    <script src="{{ asset('js/flatpickr.min.js') }}"></script>

     <style>
 /* Aside avec slide in/out */
aside {
    height: initial;
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


   /* Style pour surligner les dates avec événements */
.flatpickr-day.event-day {
    border-color: #429731 !important;
    color: #205a17 !important;
    border-radius: 50% !important;
}


.activities {
    background: #fff;
    border-radius: 10px;
    padding: 15px;
    margin-top: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    width: 35%;
}

.activity-list {
    max-height: 400px;
    overflow-y: auto;
}

.activity-item {
    display: flex;
    gap: 10px;
    border-bottom: 1px solid #eee;
    padding: 8px 0;
}

.activity-item:hover {
    background: #f9fafc;
}

.activity-item .icon {
    font-size: 1.3rem;
}

.activity-item .time {
    color: #999;
    font-size: 0.8rem;
}

        input, textarea {
            padding: 8px;
            margin: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
.eventAdd{
  /* display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
  border: 1px solid #111827;
  border-radius: 30px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.267);
  background-color: white; */

  background-color: #eee;
  width: 35%;
  display: flex;
  align-items: center;
  flex-direction: column;
  gap: 10px;
  border-radius: 30px;
  padding: 20px;
  border: none;
  box-shadow: -10px -10px 20px white, 10px 10px 20px rgb(153, 161, 175), inset -10px -10px 20px rgb(209, 213, 220);

}

.button{
  position: relative;
  overflow: hidden;
  height: 3rem;
  padding: 0 2rem;
  border-radius: 1.5rem;
  background: #3d3a4e;
   background-color: #e5e7eb;
    background-size: auto;
  background-size: 400%;
  color: #4b4b4b;
  border: none;
  cursor: pointer;
  box-shadow: -10px -10px 20px white, 10px 10px 20px rgb(153, 161, 175), inset -10px -10px 20px rgb(209, 213, 220);

}

.button:hover{
    color: white;
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

.eventAdd form{
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 80%;
}

.eventAdd form input{
    width: 100%;
}

.eventAdd form textarea{
    width: 100%;
}



.bottom{
    display: flex;
    gap: 30px;
    padding: 30px;
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
    </nav>



<div class="main-conteneur">
 <h1>Administrateurs</h1>

<!-- Bouton Ajouter -->
<button id="openModal" style="background:#2563eb; color:white; padding:10px 20px; border-radius:8px; cursor:pointer;">
    + Ajouter
</button>


<div class="top" style="display: flex; gap:30px;">
<!-- Liste des admins -->
<table style="width: 65%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Téléphone</th>
            <th>Action</th>
        </tr>
    </thead>
   <tbody>
        @foreach($admins as $admin)
        <tr>
            <td>{{ $admin->id }}</td>
            <td>{{ $admin->username }}</td>
            <td>{{ $admin->email ?? '—' }}</td>
            <td>{{ $admin->adresse ?? '—' }}</td>
            <td>{{ $admin->telephone ?? '—' }}</td>

             <td style="border:none;">
                        <!-- Bouton modifier -->
                         <a href="{{ route('admin.edit', $admin->id) }}" style="padding:5px 10px; background:#007bff; color:white; border-radius:5px; text-decoration:none;">Modifier</a>
                        <!-- Bouton Supprimer -->
                        <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Voulez-vous vraiment supprimer cet admin ?');">Supprimer</button>
                        </form>

              </td>
        </tr>
        @endforeach
    </tbody>
</table>


<div class="activities">
    <h3>🕓 Activités récentes</h3>

    <div class="activity-list">
        @forelse($activities as $activity)
            <div class="activity-item">
                <div class="icon">
                    @switch($activity->action)
                        @case('ajouté') 🟢 @break
                        @case('modifié') 🟡 @break
                        @case('supprimé') 🔴 @break
                        @default 🔵
                    @endswitch
                </div>
                <div class="content">
                    <strong>{{ $activity->admin->username ?? 'Admin inconnu' }}</strong>
                    <span> a {{ $activity->action }} l' {{ $activity->model_type }}</span><br>
                    <small>{{ $activity->details }}</small><br>
                    <small class="time">{{ $activity->created_at->diffForHumans() }}</small>
                </div>
            </div>
        @empty
            <p>Aucune activité récente.</p>
        @endforelse
    </div>
</div>


</div>


<!-- Modal Formulaire -->
<div id="adminModal" style="display:none; position:fixed; inset:0; background: rgba(0,0,0,0.4); backdrop-filter: blur(5px); justify-content:center; align-items:center;">
    <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(15px); padding:30px; border-radius:12px; width:90%; max-width:400px; position:relative; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
        <span id="closeModal" style="position:absolute; top:15px; right:15px; cursor:pointer; font-size:1.2rem;">✖</span>
        <h2>Ajouter un administrateur</h2>

        @if ($errors->any())
            <div style="background: #fef3c7; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: #b45309;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.store') }}" method="POST" style="display:flex; flex-direction:column; gap:15px; margin-top:15px;">
            @csrf
             <div>
                <label for="username" style="color:white;">Nom d’utilisateur</label>
                <input type="text" name="username" id="username" required 
                       placeholder="Ex: AdminPrincipal"
                       style="width:100%; padding:8px; border-radius:6px; border:none; background: rgba(255,255,255,0.2); color:white;">
            </div>

            <div>
                <label for="email" style="color:white;">Email</label>
                <input type="email" name="email" id="email" required 
                       placeholder="exemple@omda.mg"
                       style="width:100%; padding:8px; border-radius:6px; border:none; background: rgba(255,255,255,0.2); color:white;">
            </div>

            <div>
                <label for="adresse" style="color:white;">Adresse</label>
                <input type="text" name="adresse" id="adresse" required 
                       placeholder="Ex: Antananarivo"
                       style="width:100%; padding:8px; border-radius:6px; border:none; background: rgba(255,255,255,0.2); color:white;">
            </div>

            <div>
                <label for="telephone" style="color:white;">Numéro de téléphone</label>
                <input type="text" name="telephone" id="telephone" required 
                       placeholder="Ex: +261 34 00 000 00"
                       style="width:100%; padding:8px; border-radius:6px; border:none; background: rgba(255,255,255,0.2); color:white;">
            </div>

            <div>
                <label for="password" style="color:white;">Mot de passe</label>
                <input type="password" name="password" id="password" required placeholder="********" style="width:100%; padding:8px; border-radius:6px; border:none; background: rgba(255,255,255,0.2); color:white;">
            </div>
            <button type="submit" style="background:#2563eb; color:white; padding:15px; border-radius:6px;">Ajouter</button>
        </form>
    </div>
</div>


<div class="bottom">

    <div class="eventAdd">
   
    <h2 style="text-align:center;">Ajout d' événements</h2>
    <form method="POST" action="{{ route('events.store') }}">
        @csrf
        <input type="text" name="title" placeholder="Titre de l’événement" required>
        <input type="date" name="start" required>
        <input type="date" name="end">
        <textarea name="description">Description</textarea>
        <button type="submit" class="button"><span class="button-content">Ajouter</span></button>
    </form>

    </div>


    <div id="calendar-container">
    <h2 style="text-align:center;">🗓️ Calendrier des événements</h2>
    <input type="text" id="calendar" style="display: none">
    </div>
    


    <!-- Modal pour modifier/supprimer un événement -->
<div id="editEventModal" style="display:none; position:fixed; inset:0; background: rgba(0,0,0,0.4); backdrop-filter: blur(5px); justify-content:center; align-items:center;">
    <div style="background:white; padding:20px; border-radius:12px; width:90%; max-width:400px; position:relative; box-shadow:0 8px 20px rgba(0,0,0,0.3);">
        <span id="closeEditModal" style="position:absolute; top:10px; right:15px; cursor:pointer; font-size:1.2rem;">✖</span>
        <h2>Détails de l'événement</h2>
        <form id="editEventForm">
            @csrf
            <input type="hidden" id="editEventId">
            <input type="text" id="editEventTitle" placeholder="Titre" required style="width:100%; padding:8px; margin:10px 0; border-radius:6px; border:1px solid #ccc;">
            <input type="date" id="editEventStart" required style="width:100%; padding:8px; margin:10px 0; border-radius:6px; border:1px solid #ccc;">
            <input type="date" id="editEventEnd" style="width:100%; padding:8px; margin:10px 0; border-radius:6px; border:1px solid #ccc;">
            <textarea id="editEventDescription" style="width:100%; padding:8px; margin:10px 0; border-radius:6px; border:1px solid #ccc;"></textarea>
            <button type="submit" style="background:#2563eb; color:white; padding:10px; border-radius:6px;">Modifier</button>
            <button type="button" id="deleteEventBtn" style="background:#ee6060; color:white; padding:10px; border-radius:6px; margin-top:10px;">Supprimer l'évènement</button>
        </form>
    </div>
</div>


<div class="all-events">
    <h2 style="text-align:center;">📋 Tous les événements</h2>

    <ul style="list-style:none; padding:0; max-width:600px; margin: 20px auto;">
        @foreach($events as $event)
            <li style="margin:10px 0; padding:10px; border-radius:8px; background:#f1f5f9; box-shadow:0 2px 6px rgba(0,0,0,0.1); cursor:pointer;"
                class="jump-to-date"
                data-date="{{ \Carbon\Carbon::parse($event->start)->format('Y-m-d') }}">
                <strong>{{ $event->title }}</strong><br>
                <small>{{ \Carbon\Carbon::parse($event->start)->format('d/m/Y') }}
                    @if($event->end)
                        - {{ \Carbon\Carbon::parse($event->end)->format('d/m/Y') }}
                    @endif
                </small>
            </li>
        @endforeach
    </ul>

    <div style="text-align:center; margin-top:20px;">
        {{ $events->links() }}
    </div>
</div>





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


    // Transformer les dates d'événements au format Y-m-d
    const eventDates = @json($eventDates);

flatpickr("#calendar", {
    inline: true,
    locale: "fr",
    dateFormat: "Y-m-d",
    disableMobile: true,
    onDayCreate: function(dObj, dStr, fp, dayElem) {
        const dateStr = fp.formatDate(dayElem.dateObj, "Y-m-d");
        if(eventDates.includes(dateStr)) {
            dayElem.classList.add("event-day");
        }
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const eventDates = @json($formattedEvents); // tous les événements
    const calendarInput = document.querySelector("#calendar");
    const editModal = document.getElementById('editEventModal');
    const closeEditModal = document.getElementById('closeEditModal');
    const deleteBtn = document.getElementById('deleteEventBtn');
    const editForm = document.getElementById('editEventForm');

    flatpickr(calendarInput, {
        inline: true,
        locale: "fr",
        dateFormat: "Y-m-d",
        disableMobile: true,

        onDayCreate: function(dObj, dStr, fp, dayElem) {
            const uniqueEvents = eventDates.filter(
    (ev, index, self) => ev.id !== undefined && index === self.findIndex(e => e.id === ev.id)
);
            const dateStr = fp.formatDate(dayElem.dateObj, "Y-m-d");
           const dayEvents = uniqueEvents.filter(ev => ev.start.startsWith(dateStr));

            // Élimine les doublons côté JS


            // Si des événements existent ce jour-là
            if (dayEvents.length > 0) {
                dayElem.classList.add("event-day");
                dayElem.style.cursor = "pointer";

                // ✅ Empêche plusieurs listeners sur le même jour
                if (!dayElem.dataset.listenerAdded) {
                    dayElem.dataset.listenerAdded = "true";

                    dayElem.addEventListener('click', function() {
                        // Supprime les anciens popups avant d’en créer un nouveau
                        document.querySelectorAll('.event-popup').forEach(p => p.remove());

                        if (dayEvents.length === 1) {
                            openEditModal(dayEvents[0]);
                        } else {
                            showEventList(dayEvents);
                        }
                    });
                }
            }
        }
    });

    // ✅ Fonction d’affichage du popup liste
    function showEventList(events) {
        document.querySelectorAll('.event-popup').forEach(p => p.remove());

        const popup = document.createElement('div');
        popup.classList.add('event-popup');
        Object.assign(popup.style, {
            position: 'fixed',
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            background: 'white',
            padding: '20px',
            borderRadius: '10px',
            boxShadow: '0 8px 20px rgba(0,0,0,0.3)',
            zIndex: 1000,
            width: '90%',
            maxWidth: '400px'
        });

        // ✅ Supprime les doublons (si jamais ils existent)
        const uniqueEvents = events.filter(
            (ev, index, self) => index === self.findIndex(e => e.id === ev.id)
        );

        popup.innerHTML = `
            <h3 style="text-align:center;">Événements de ce jour</h3>
            <ul style="list-style:none; padding:0; margin:10px 0;">
                ${uniqueEvents.map(ev => `
                    <li style="margin:8px 0;">
                        <button class="choose-event" 
                            data-id="${ev.id}" 
                            style="width:100%; text-align:left; border:none; background:#f1f5f9; padding:10px; border-radius:8px; cursor:pointer;">
                            ${ev.title} — ${ev.start.substring(11,16)}
                        </button>
                    </li>
                `).join('')}
            </ul>
            <div style="text-align:right;">
                <button id="closePopup" style="background:#dc2626; color:white; padding:8px 12px; border-radius:8px;">Fermer</button>
            </div>
        `;

        document.body.appendChild(popup);

        // Choix d’un événement
        popup.querySelectorAll('.choose-event').forEach(btn => {
            btn.addEventListener('click', () => {
                const selected = uniqueEvents.find(e => e.id == btn.dataset.id);
                popup.remove();
                openEditModal(selected);
            });
        });

        // Fermer
        popup.querySelector('#closePopup').addEventListener('click', () => popup.remove());
    }

    // ✅ Fonction d’ouverture du modal de modification
    function openEditModal(ev) {
        document.getElementById('editEventId').value = ev.id;
        document.getElementById('editEventTitle').value = ev.title;
        document.getElementById('editEventStart').value = ev.start;
        document.getElementById('editEventEnd').value = ev.end || '';
        document.getElementById('editEventDescription').value = ev.description || '';
        editModal.style.display = 'flex';
    }

    closeEditModal.addEventListener('click', () => editModal.style.display = 'none');
    window.addEventListener('click', e => { if (e.target == editModal) editModal.style.display = 'none'; });

    // ✅ Modifier via Ajax
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editEventId').value;
        fetch(`/events/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                title: document.getElementById('editEventTitle').value,
                start: document.getElementById('editEventStart').value,
                end: document.getElementById('editEventEnd').value,
                description: document.getElementById('editEventDescription').value
            })
        }).then(res => res.json())
          .then(res => {
              if(res.success) location.reload();
          });
    });

    // ✅ Supprimer via Ajax
    deleteBtn.addEventListener('click', function() {
        const id = document.getElementById('editEventId').value;
        if(confirm("Voulez-vous vraiment supprimer cet événement ?")) {
            fetch(`/events/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            }).then(res => res.json())
              .then(res => { if(res.success) location.reload(); });
        }
    });
});

document.querySelectorAll('.jump-to-date').forEach(item => {
    item.addEventListener('click', () => {
        const date = item.dataset.date;
        if(calendarInput._flatpickr) {
            calendarInput._flatpickr.setDate(date, true);   // sélectionne la date
            calendarInput._flatpickr.jumpToDate(date);      // centre la vue sur la date
        }
    });
});




</script>








</div>
 

<aside class="silde-in-right">
    <img src="images/logo3.png" alt="">
    <h2>Bienvenue dans votre centre d'Administration</h2>
    <h3 class="username">{{$username}}</h1>
        <div class="link">
            <ul>
                <li>
                    <a href="{{ route('admin.information') }}">
                        Mes informations
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.gestion') }}">
                        Gerer Mon Compte 
                    </a>
                </li>
            </ul>
        </div>
</aside>

</div>
</body>
</html>