<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<h1>Œuvres - {{ $categorie }}</h1>

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
{{ $oeuvres->links() }}
@else
<p>Aucune œuvre dans cette catégorie.</p>
@endif
