<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AplicacionProducto extends Model
{
    protected $table = 'aplicacion_producto';

    protected $fillable = [
        'aplicacion_id',
        'producto_id',
    ];

    public function aplicacion()
    {
        return $this->belongsTo(Aplicacion::class, 'aplicacion_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
