<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Logo;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('orden', 'asc')->get();
        $categorias = Categoria::orderBy('orden', 'asc')->get();
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        // Agregar la url pública del video si existe
        foreach ($productos as $producto) {
            if ($producto->video) {
                $producto->video = Storage::url($producto->video);
            }
            if ($producto->ficha) {
                $producto->ficha = Storage::url($producto->ficha);
            }
        }
        return inertia('Admin/Productos', [
            'productos' => $productos,
            'categorias' => $categorias,
            'logo' => $logo
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria_id' => 'required',
            'ficha' => 'nullable|mimes:pdf|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov|max:100000',
            'adword' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        
        $fichaPath = null;
        if ($request->hasFile('ficha')) {
            $file = $request->file('ficha');
            $fichaPath = $file->store('fichas');
        }

        $videoPath = null;
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $videoPath = $file->store('videos');
        }

        $producto = Producto::create([
            'orden' => $request->orden,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'categoria_id' => $request->categoria_id,
            'ficha' => $fichaPath,
            'video' => $videoPath,
            'adword' => $request->adword,
        ]);


        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('productos.dashboard')->with('message', 'Producto creado exitosamente');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'orden' => 'nullable|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required',
            'ficha' => 'nullable|mimes:pdf|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov|max:100000',
            'adword' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $producto = Producto::find($id);

        // Inicializar variables para evitar null
        $fichaPath = $producto->ficha;
        $videoPath = $producto->video;

        if ($request->hasFile('ficha')) {
            $ruta = $producto->ficha;
            $file = $request->file('ficha');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            $fichaPath = $file->store('fichas');
        }

        if ($request->hasFile('video')) {
            $ruta = $producto->video;
            $file = $request->file('video');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            $videoPath = $file->store('videos');
        }

        $producto->update(array_filter([
            'orden' => $request->orden ?? $producto->orden,
            'titulo' => $request->titulo ?? $producto->titulo,
            'descripcion' => $request->descripcion ?? $producto->descripcion,
            'categoria_id' => $request->categoria_id ?? $producto->categoria_id,
            'ficha' => $fichaPath,
            'video' => $videoPath,
            'adword' => $request->adword ?? $producto->adword,
        ]));

        $producto->save();
        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('productos.dashboard')->with('message', 'Producto actualizado exitosamente');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        if ($producto->ficha) {
            if (Storage::exists($producto->ficha)) {
                Storage::delete($producto->ficha);
            }
        }
        if ($producto->video) {
            if (Storage::exists($producto->video)) {
                Storage::delete($producto->video);
            }
        }
        $producto->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('productos.dashboard')->with('message', 'Producto eliminado exitosamente');
    }
    public function toggleDestacado(Request $request)
    {
        $producto = Producto::findOrFail($request->id);
        $producto->destacado = $request->destacado ? 1 : 0;
        $producto->save();

        return redirect()->route('productos.dashboard')->with('message', 'Producto destacado exitosamente');
    }
}
