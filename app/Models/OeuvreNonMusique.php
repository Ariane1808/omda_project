<?php

namespace App\Models;

use App\Models\OeuvreNonMusique;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OeuvreNonMusique extends Model
{
    use HasFactory;

    protected $table = 'oeuvres_non_musiques';
    protected $primaryKey = 'code_titre';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['code_titre', 'date_depot', 'num', 'titre', 'categories', 'auteur', 'part'];
          public $timestamps = false;
    public function oeuvresNonMusique()
    {
        return $this->hasMany(Artist::class, 'num', 'num');
    }
}

