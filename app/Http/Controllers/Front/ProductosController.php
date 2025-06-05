<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Categoria;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('orden', 'asc')->get();
        foreach ($categorias as $categoria) {
            $categoria->path = asset('storage/' . $categoria->path);
        }
        $banner = Banner::where('seccion', 'categorias')->first();
        $banner->path = asset('storage/' . $banner->path);
        $metadatos = Metadato::where('seccion', 'productos')->first();
        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'facebook', 'instagram', 'linkedin')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.categorias', compact('categorias', 'banner', 'metadatos', 'logos', 'contactos', 'whatsapp'));
    }
    public function show(Request $request, $id)
    {

        $productos = Producto::where('categoria_id', $id)->orderBy('orden', 'asc')->get();
        
        // Procesamos las imágenes de los productos
        foreach ($productos as $producto) {
            $imagenPrincipal = $producto->imagenPrincipal()->first();
            if ($imagenPrincipal && $imagenPrincipal->path) {
                $producto->imagen = asset('storage/' . $imagenPrincipal->path);
            } else {
                $producto->imagen = null;
            }
        }
        $categoria = Categoria::findOrFail($id);
        $categorias = Categoria::orderBy('orden', 'asc')->get();
        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'facebook', 'instagram', 'linkedin')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.productos', compact('productos', 'categorias', 'logos', 'contactos', 'whatsapp', 'categoria'));
    }
    public function showProducto($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->imagenes->each(function ($imagen) {
            $imagen->path = asset('storage/' . $imagen->path);
        });
        $producto->colocaciones->each(function ($colocacion) {
            $colocacion->path = asset('storage/' . $colocacion->path);
        });
        $producto->video = $producto->video ? asset('storage/' . $producto->video) : null;
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
