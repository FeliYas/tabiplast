<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Colocacion;
use App\Models\Logo;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ColocacionController extends Controller
{
    public function index($id)
    {
        $producto = Producto::findOrFail($id);
        $colocaciones = Colocacion::where('producto_id', $id)->orderBy('orden', 'asc')->get();
        foreach ($colocaciones as $colocacion) {
            $colocacion->path = Storage::url($colocacion->path);
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Colocacion', [
            'colocaciones' => $colocaciones,
            'producto' => $producto,
            'logo' => $logo
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'producto_id' => 'required|exists:productos,id',
            'path' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'orden' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        
        $imagePath = null;
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $imagePath=$file->store('images');
        } 

        $colocacion = Colocacion::create([
            'orden'              => $request->orden,
            'path'               => $imagePath,
            'producto_id'        => $request->producto_id,
            'titulo'             => $request->titulo,
            'descripcion'        => $request->descripcion,
        ]);

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('colocacion.dashboard', ['id' => $request->producto_id])->with('message', 'Colocación agregada exitosamente');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'orden' => 'nullable|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $colocacion = Colocacion::findOrFail($id);

        if ($request->hasFile('path')) {
            $ruta= $colocacion->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath=$file->store('images');
            
        }
        // Solo se actualizan los campos si el request contiene un valor
        $colocacion->update(array_filter([
            'orden' => $request->orden,
            'path' => $imagePath ?? $colocacion->path,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
        ]));
        
        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('colocacion.dashboard', ['id' => $colocacion->producto_id])->with('message', 'Colocación actualizada exitosamente');
    }
    public function destroy($id)
    {
        $colocacion = Colocacion::findOrFail($id);

        // Eliminar la imagen del almacenamiento si es necesario
        if ($colocacion->path) {
            if (Storage::exists($colocacion->path)) {
                Storage::delete($colocacion->path);
            }
        }
        $colocacion->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('colocacion.dashboard', ['id' => $colocacion->producto_id])->with('message', 'Colocación eliminada exitosamente');
    }
}
