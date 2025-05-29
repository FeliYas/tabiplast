<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'orden',
        'titulo',
        'tituloen',
        'tituloport',
        'descripcion',
        'descripcionen',
        'descripcionport',
        'categoria_id',
        'ficha',
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
    
    public function aplicaciones()
    {
        return $this->belongsToMany(Aplicacion::class, 'aplicacion_producto', 'producto_id', 'aplicacion_id');
    }
}
