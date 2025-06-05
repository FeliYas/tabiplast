<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Contacto;
use App\Models\Contenido;
use App\Models\Logo;
use App\Models\Novedad;
use App\Models\Producto;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
     public function index()
    {
        $logos = Logo::whereIn('seccion', ['home', 'navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $sliders = Slider::orderBy('orden', 'asc')->get();
        foreach ($sliders as $slider) {
            $slider->path = asset('storage/' . $slider->path);
        }
        $categorias = Categoria::where('destacado', 1)->orderBy('orden', 'asc')->take(6)->get();
        foreach ($categorias as $categoria) {
            $categoria->path = asset('storage/' . $categoria->path);
        }
        $productos = Producto::where('destacado', 1)->orderBy('orden', 'asc')->get();
        foreach ($productos as $producto) {
            $imagenPrincipal = $producto->imagenPrincipal()->first();
            if ($imagenPrincipal && $imagenPrincipal->path) {
                $producto->imagen = asset('storage/' . $imagenPrincipal->path);
            } else {
                $producto->imagen = null;
            }
        }
        $contenido = Contenido::first();
        $contenido->path = asset('storage/' . $contenido->path);
        $novedades = Novedad::orderBy('orden', 'asc')->take(3)->get();
        foreach ($novedades as $nov) {
            $nov->path = asset('storage/' . $nov->path);
        }
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'facebook', 'instagram', 'linkedin')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.home', compact('logos', 'sliders', 'categorias', 'productos', 'contenido', 'novedades', 'contactos', 'whatsapp'));

    }
}
