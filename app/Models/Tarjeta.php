<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    protected $fillable = [
        'path',
        'titulo',
        'descripcion',
    ];

}
