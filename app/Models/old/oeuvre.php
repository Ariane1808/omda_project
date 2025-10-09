<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oeuvre extends Model
{
    protected $table = 'oeuvres'; // ou le nom réel
    public $timestamps = false;

    protected $fillable = ['artist_id','titre','type','annee'];

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }
}
