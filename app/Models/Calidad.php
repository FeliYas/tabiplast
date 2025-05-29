<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calidad extends Model
{
    protected $table = 'calidad';
    protected $fillable = [
        'path',
        'titulo',
        'descripcion',
        'tituloen',
        'descripcionen',
        'tituloport',
        'descripcionport',
        'iso1',
        'iso2',
    ];

}
