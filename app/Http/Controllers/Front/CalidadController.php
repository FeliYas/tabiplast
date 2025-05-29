<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Calidad;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use Illuminate\Http\Request;

class CalidadController extends Controller
{
     public function index()
    {
        $calidad = Calidad::first();
        $calidad->path = asset('storage/' . $calidad->path);
        $metadatos = Metadato::where('seccion', 'calidad')->first();
        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'telefono2')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.calidad', compact('calidad', 'metadatos', 'logos', 'contactos', 'whatsapp'));
    }
}
