<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'action', 'model_type', 'details'
    ];

   public function admin()
{
    return $this->belongsTo(Admin::class, 'user_id');
}

}
