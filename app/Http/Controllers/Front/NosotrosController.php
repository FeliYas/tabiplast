<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use App\Models\Nosotros;
use App\Models\Tarjeta;
use Illuminate\Http\Request;

class NosotrosController extends Controller
{
    public function index()
    {
        $nosotros = Nosotros::first();
        $nosotros->path = asset('storage/' . $nosotros->path);
        $nosotros->video = asset('storage/' . $nosotros->video);
        $nosotros->banner = asset('storage/' . $nosotros->banner);
        $tarjetas = Tarjeta::all();
        foreach ($tarjetas as $tarjeta) {
            $tarjeta->path = asset('storage/' . $tarjeta->path);
        }
        $metadatos = Metadato::where('seccion', 'nosotros')->first();
        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'facebook', 'instagram', 'linkedin')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.nosotros', compact('nosotros', 'tarjetas', 'metadatos', 'logos', 'contactos', 'whatsapp'));
    }
}
