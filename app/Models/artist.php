<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artistes'; 
    protected $primaryKey = 'num'; 
    public $incrementing = true;
    protected $keyType = 'int'; 
    public $timestamps = false;

    protected $fillable = [
        'num_wipo','date_adh','num','categorie','nom','pseudo','groupes','contact','email','adresse','province','sexe','cin','date_naissance','pension','statut','hologramme'
    ];

public function oeuvresMusique()
{
    return $this->hasMany(OeuvreMusique::class, 'num', 'num');
}

public function oeuvresNonMusique()
{
    return $this->hasMany(OeuvreNonMusique::class, 'num', 'num');
}
// les premiers num sont les FK des tables
}


                    // <!-- <tr data-href="{{ route('artists.oeuvres', $artist->id) }}" class="artist-row"> -->

//  <!-- <a href="{{ route('artists.edit', $artist->id) }}" style="padding:5px 10px; background:#007bff; color:white; border-radius:5px; text-decoration:none;">Modifier</a> -->