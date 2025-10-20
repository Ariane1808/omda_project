<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin'; // nom de la table
    public $timestamps = false;  // si tu n’as pas created_at/updated_at
    protected $fillable = ['username', 'password','adresse','email','telephone','role','session_id','last_activity'];
}
