<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplicacion extends Model
{
    protected $table = 'aplicaciones';

    protected $fillable = [
        'orden',
        'path',
        'titulo',
        'tituloen',
        'tituloport',
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'aplicacion_producto', 'aplicacion_id', 'producto_id');
    }
}
