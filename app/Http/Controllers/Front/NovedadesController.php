<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use App\Models\Novedad;
use Illuminate\Http\Request;

class NovedadesController extends Controller
{
    public function index()
    {
        $novedadesDestacadas = Novedad::orderBy('orden', 'asc')->take(3)->get();
        foreach ($novedadesDestacadas as $novedad) {
            $novedad->path = asset('storage/' . $novedad->path);
        }
        $novedades = Novedad::orderBy('orden', 'asc')->get();
        foreach ($novedades as $novedad) {
            $novedad->path = asset('storage/' . $novedad->path);
        }
        $banner = Banner::where('seccion', 'novedades')->first();
        if ($banner) {
            $banner->path = asset('storage/' . $banner->path);
        }
        $metadatos = Metadato::where('seccion', 'novedades')->first();
        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'facebook', 'instagram', 'linkedin')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.novedades', compact('novedadesDestacadas', 'novedades', 'banner', 'metadatos', 'logos', 'contactos', 'whatsapp'));
    }
    public function show($id)
    {
        $novedadElegida = Novedad::findOrFail($id);
        $novedadElegida->path = asset('storage/' . $novedadElegida->path);
        $novedades = Novedad::orderBy('orden', 'asc')->get();
        foreach ($novedades as $novedad) {
            $novedad->path = asset('storage/' . $novedad->path);
        }
        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'facebook', 'instagram', 'linkedin')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.novedad', compact('novedadElegida', 'novedades', 'logos', 'contactos', 'whatsapp'));
    }
}
