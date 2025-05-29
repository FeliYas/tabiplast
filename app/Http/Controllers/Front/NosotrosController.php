<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use App\Models\Nosotros;
use Illuminate\Http\Request;

class NosotrosController extends Controller
{
    public function index()
    {
        $nosotros = Nosotros::first();
        $nosotros->path = asset('storage/' . $nosotros->path);
        $banners = Banner::orderby('orden', 'asc')->get();
        foreach ($banners as $banner) {
            $banner->path = asset('storage/' . $banner->path);
        }
        $metadatos = Metadato::where('seccion', 'nosotros')->first();
        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'telefono2')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.nosotros', compact('nosotros', 'banners', 'metadatos', 'logos', 'contactos', 'whatsapp'));
    }
}
