<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    protected $fillable = [
        'path',
        'titulo',
        'descripcion',
        'tituloen',
        'descripcionen',
        'tituloport',
        'descripcionport',
    ];
}
