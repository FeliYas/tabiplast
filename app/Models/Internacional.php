<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internacional extends Model
{
    protected $table = 'internacional';

    protected $fillable = [
        'path',
        'titulo',
        'descripcion',
        'banner',
    ];
}
