<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Contacto;
use App\Models\Internacional;
use App\Models\Logo;
use App\Models\Metadato;
use Illuminate\Http\Request;

class InternacionalController extends Controller
{
    public function index()
    {
        $internacional = Internacional::first();
        $internacional->path = asset('storage/' . $internacional->path);
        $internacional->banner = asset('storage/' . $internacional->banner);
        $metadatos = Metadato::where('seccion', 'internacional')->first();
        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'facebook', 'instagram', 'linkedin')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;

        return view('front.internacional', compact('internacional','metadatos','logos', 'contactos', 'whatsapp'));
    }
}
