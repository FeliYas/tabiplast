<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AplicacionProducto;
use App\Models\Aplicacion;
use App\Models\Logo;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AplicacionProductoController extends Controller
{
    public function index($id)
    {
        // Primero encontramos la aplicación por su ID
        $aplicacion = Aplicacion::findOrFail($id);
        $aplicacion->path = Storage::url($aplicacion->path);
        // Obtenemos todos los productos relacionados con esta aplicación
        $productosRelacionados = $aplicacion->productos()->with('categoria')->get();
        $productos = Producto::orderby('orden' , 'asc')->get();
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);

        return inertia('Admin/Relacionados', [
            'aplicacion' => $aplicacion,
            'productosRelacionados' => $productosRelacionados,
            'productos' => $productos,
            'logo' => $logo
        ]);
    }

    /**
     * Almacenar nuevas relaciones entre una aplicación y múltiples productos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'aplicacion_id' => 'required|exists:aplicaciones,id',
            'productos' => 'required|array',
            'productos.*' => 'exists:productos,id',
        ]);

        $aplicacion = Aplicacion::findOrFail($validated['aplicacion_id']);
        
        // Obtener los IDs de productos ya relacionados
        $productosActuales = $aplicacion->productos()->pluck('productos.id')->toArray();
        
        // Obtener los productos seleccionados
        $nuevoProductosIds = $validated['productos'];
        
        // Combinar productos actuales con los nuevos (sin duplicar)
        $todosProductosIds = array_unique(array_merge($productosActuales, $nuevoProductosIds));
        
        // Sincronizar productos a la aplicación (mantiene los existentes y añade los nuevos)
        $aplicacion->productos()->sync($todosProductosIds);
        
        return redirect()->route('relacionados.dashboard', $aplicacion->id)
            ->with('success', 'Productos agregados exitosamente a la aplicación.');
    }

    /**
     * Eliminar una relación entre aplicación y producto.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Primero buscamos la relación aplicación-producto
        $relacion = AplicacionProducto::findOrFail($id);
        $aplicacionId = $relacion->aplicacion_id;
        
        // Eliminamos la relación
        $relacion->delete();
        
        return redirect()->route('relacionados.dashboard', $aplicacionId)
            ->with('success', 'Producto eliminado exitosamente de esta aplicación.');
    }
}
