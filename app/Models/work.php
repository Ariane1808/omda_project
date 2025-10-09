<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class work extends Model
{
    protected $table = 'oeuvres';
    public $timestamps = false; // si pas de created_at / updated_at
    protected $fillable = ['titre', 'type', 'annee', 'artiste_id', 'identifie']; // colonnes de ta table
}
