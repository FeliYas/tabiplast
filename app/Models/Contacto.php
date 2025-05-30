<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $table = 'contacto';

    protected $fillable = [
        'direccion',
        'telefono',
        'email',
        'facebook',
        'instagram',
        'iframe',
        'whatsapp'
    ];
}
