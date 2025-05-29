<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use App\Models\Novedad;
use App\Models\Novedade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NovedadesController extends Controller
{
    public function index()
    {
        $novedades = Novedad::orderby('orden', 'asc')->get();
        foreach ($novedades as $novedad) {
            $novedad->path = Storage::url($novedad->path);
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Novedades', [
            'novedades' => $novedades,
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
            'descripcion'          => 'required|string',
            'descripcionen'        => 'required|string',
            'descripcionport'        => 'required|string',
            'path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        $imagePath = null;
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $imagePath=$file->store('images');
        } 

        // Crear la novedad con los datos validados
        $novedad = Novedad::create([
            'orden'              => $request->orden,
            'titulo'             => $request->titulo,
            'tituloen'          => $request->tituloen,
            'tituloport'          => $request->tituloport,
            'descripcion'        => $request->descripcion,
            'descripcionen'        => $request->descripcionen,
            'descripcionport'        => $request->descripcionport,
            'path'               => $imagePath,
        ]);

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('novedades.dashboard')->with('message', 'Novedad creada exitosamente');
    }
    public function update(Request $request, $id)
    {

        // Validar los campos del formulario
        $validator = Validator::make($request->all(), [
            'orden'                => 'nullable|string|max:255',
            'titulo'               => 'nullable|string|max:255',
            'tituloen'            => 'nullable|string|max:255',
            'tituloport'            => 'nullable|string|max:255',
            'descripcion'          => 'nullable|string',
            'descripcionen'        => 'nullable|string',
            'descripcionport'        => 'nullable|string',
            'path'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        // Obtener el registro de Novedades
        $novedades = Novedad::findOrFail($id);

        if ($request->hasFile('path')) {
            $ruta= $novedades->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath=$file->store('images');
            
        }

        $novedades->orden              = $request->orden;
        $novedades->titulo             = $request->titulo;
        $novedades->tituloen          = $request->tituloen;
        $novedades->tituloport          = $request->tituloport;
        $novedades->descripcion        = $request->descripcion;
        $novedades->descripcionen        = $request->descripcionen;
        $novedades->descripcionport        = $request->descripcionport;
        $novedades->path               = $imagePath ?? $novedades->path;
        // Guardar los cambios en Novedades
        $novedades->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('novedades.dashboard')->with('message', 'Novedad actualizada exitosamente');
    }

    public function destroy($id)
    {
        // Find the Novedades by id
        $novedades = Novedad::findOrFail($id);

        // Eliminar la imagen del almacenamiento si es necesario
        if ($novedades->path) {
            if (Storage::exists($novedades->path)) {
                Storage::delete($novedades->path);
            }
        }

        // Eliminar el registro de la base de datos
        $novedades->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('novedades.dashboard')->with('message', 'Novedad eliminada exitosamente');
    }
}
