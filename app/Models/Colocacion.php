<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocacion extends Model
{
    protected $table = 'colocaciones';

    protected $fillable = [
        'orden',
        'path',
        'titulo',
        'descripcion',
        'producto_id',
    ];
    
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
