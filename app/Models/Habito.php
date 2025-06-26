<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habito extends Model
{
    protected $fillable = [
        'user_id',
        'fecha',
        'agua',
        'sueno',
        'actividad_fisica',
        'alimentacion',
    ];
}
