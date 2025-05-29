<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Aplicacion;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use Illuminate\Http\Request;

class AplicacionesController extends Controller
{
    public function index()
    {       
        $aplicaciones = Aplicacion::orderBy('orden', 'asc')->get();
        foreach ($aplicaciones as $aplicacion) {
            $aplicacion->path = asset('storage/' . $aplicacion->path);
        }
        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $metadatos = Metadato::where('seccion', 'aplicaciones')->first();
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'telefono2')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.aplicaciones', compact('aplicaciones', 'logos', 'metadatos', 'contactos', 'whatsapp'));
    }
    public function show($id)
    {
        $aplicacion = Aplicacion::findOrFail($id);
        $aplicacion->path = asset('storage/' . $aplicacion->path);
        
        $productos = $aplicacion->productos()->orderBy('orden', 'asc')->get();
        foreach ($productos as $producto) {
            if ($producto->imagenes->count() > 0) {
                $producto->imagenes->first()->path = asset('storage/' . $producto->imagenes->first()->path);
            }
        }

        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'telefono2')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        
        return view('front.aplicacion', compact('aplicacion', 'productos', 'logos', 'contactos', 'whatsapp'));
    }
}
