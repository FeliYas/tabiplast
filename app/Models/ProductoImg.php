<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoImg extends Model
{
    protected $table = 'productosimgs';
    protected $fillable = [
        'orden',
        'path',
        'producto_id',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
