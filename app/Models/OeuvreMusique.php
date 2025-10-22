<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OeuvreMusique extends Model
{
    use HasFactory;

    protected $table = 'oeuvres_musiques';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id','date_depot', 'code_titre', 'titre', 'categorie', 'num', 'nom', 'pseudo', 'groupes', 'qualite', 'droit', 'part', 'hologramme'];
    public $timestamps = false;
    public function oeuvresMusique()
    {
        return $this->hasMany(Artist::class, 'num', 'num');
    }
}
