<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index(Request $request, $id = null)
    {
        // Si se especifica una categoría, filtramos los productos por esa categoría
        if ($id) {
            $productos = Producto::where('categoria_id', $id)->orderBy('orden', 'asc')->get();
        } else {
            $productos = Producto::orderBy('orden', 'asc')->get();
        }
        
        // Procesamos las imágenes de los productos
        foreach ($productos as $producto) {
            if ($producto->imagenes->count() > 0) {
                $producto->imagenes->first()->path = asset('storage/' . $producto->imagenes->first()->path);
            }
        }
        $categorias = Categoria::orderBy('orden', 'asc')->get();
        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $metadatos = Metadato::where('seccion', 'productos')->first();
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'telefono2')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.productos', compact('productos', 'categorias', 'logos', 'metadatos', 'contactos', 'whatsapp'));
    }
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->imagenes->each(function ($imagen) {
            $imagen->path = asset('storage/' . $imagen->path);
        });

        // Obtener productos relacionados (misma categoría, excluyendo el producto actual)
        $productosRelacionados = Producto::where('categoria_id', $producto->categoria_id)
            ->where('id', '!=', $producto->id)
            ->take(3)  // Limitamos a 3 productos relacionados
            ->get();
        foreach ($productosRelacionados as $productoRelacionado) {
            if ($productoRelacionado->imagenes->count() > 0) {
                $productoRelacionado->imagenes->first()->path = asset('storage/' . $productoRelacionado->imagenes->first()->path);
            }
        }

        $categorias = Categoria::orderBy('orden', 'asc')->get();
        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $contactos = Contacto::select('direccion', 'email', 'telefono')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;

        return view('front.producto', compact(
            'producto',
            'categorias',
            'logos',
            'contactos',
            'productosRelacionados',
            'whatsapp'
        ));
    }
}
