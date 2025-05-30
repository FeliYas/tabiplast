<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'orden',
        'titulo',
        'descripcion',
        'categoria_id',
        'ficha',
        'video',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function imagenes()
    {
        return $this->hasMany(ProductoImg::class)->orderBy('orden', 'asc');
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(ProductoImg::class)->orderBy('orden', 'asc');
    }

    public function colocaciones()
    {
        return $this->hasMany(Colocacion::class)->orderBy('orden', 'asc');
    }
}
