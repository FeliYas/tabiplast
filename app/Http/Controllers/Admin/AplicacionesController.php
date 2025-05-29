<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aplicacion;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AplicacionesController extends Controller
{
    public function index()
    {
        $aplicaciones = Aplicacion::withCount('productos')
            ->orderby('orden', 'asc')
            ->get();
            
        foreach ($aplicaciones as $aplicacion) {    
            $aplicacion->path = Storage::url($aplicacion->path);
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Aplicaciones', [
            'aplicaciones' => $aplicaciones,
            'logo' => $logo
        ]);
    }
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'orden'                => 'required|string|max:255',
            'titulo'               => 'required|string|max:255',
            'tituloen'            => 'required|string|max:255',
            'tituloport'            => 'required|string|max:255',
            'path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        $imagePath = null;
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $imagePath=$file->store('images');
        } 
        

        // Crear la aplicacion con los datos validados
        $aplicacion = Aplicacion::create([
            'orden'              => $request->orden,
            'titulo'             => $request->titulo,
            'tituloen'          => $request->tituloen,
            'tituloport'          => $request->tituloport,
            'path'               => $imagePath,
        ]);

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('aplicaciones.dashboard')->with('message', 'Aplicacion creada exitosamente');
    }
    public function update(Request $request, $id)
    {

        // Validar los campos del formulario
        $validator = Validator::make($request->all(), [
            'orden'                => 'nullable|string|max:255',
            'titulo'               => 'nullable|string|max:255',
            'tituloen'            => 'nullable|string|max:255',
            'tituloport'            => 'nullable|string|max:255',
            'path'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        // Obtener el registro de Aplicaciones
        $aplicacion = Aplicacion::findOrFail($id);
        
        
        if ($request->hasFile('path')) {
            $ruta= $aplicacion->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath=$file->store('images');
            
        }
        
        $aplicacion->orden      = $request->orden;
        $aplicacion->titulo     = $request->titulo;
        $aplicacion->tituloen   = $request->tituloen;
        $aplicacion->tituloport = $request->tituloport;
        $aplicacion->path       = $imagePath ?? $aplicacion->path; // Mantener la imagen anterior si no se subió una nueva
        
        // Guardar los cambios en Aplicion
        $aplicacion->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('aplicaciones.dashboard')->with('message', 'Aplicacion actualizada exitosamente');
    }

    public function destroy($id)
    {
        // Find the Aplicion by id
        $aplicacion = Aplicacion::findOrFail($id);

        // Eliminar la imagen del almacenamiento si es necesario
        if ($aplicacion->path) {
            if (Storage::exists($aplicacion->path)) {
                Storage::delete($aplicacion->path);
            }
        }

        // Eliminar el registro de la base de datos
        $aplicacion->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('aplicaciones.dashboard')->with('message', 'Aplicacion eliminado exitosamente');
    }
}
