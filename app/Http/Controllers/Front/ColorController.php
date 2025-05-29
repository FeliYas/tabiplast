<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        // Paginación de colores (36 elementos por página = 6 filas x 6 columnas)
        $colores = Color::orderBy('orden', 'asc')->paginate(36);
        
        // Agregar asset path a cada color en la colección paginada
        $colores->getCollection()->transform(function ($color) {
            $color->path = asset('storage/' . $color->path);
            return $color;
        });
        
        // Mantener los parámetros de query en los links de paginación
        $colores->withQueryString();
        
        // El resto de tu lógica se mantiene igual
        $metadatos = Metadato::where('seccion', 'carta de colores')->first();
        
        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'telefono2')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        
        return view('front.colores', compact('colores', 'metadatos', 'logos', 'contactos', 'whatsapp'));
    }
}
