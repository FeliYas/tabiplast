<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    public function index()
    {
        $colores = Color::orderby('orden', 'asc')->get();
        foreach ($colores as $color) {    
            $color->path = Storage::url($color->path);
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Colores', [
            'colores' => $colores,
            'logo' => $logo
        ]);
    }
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'orden'                => 'required|string|max:255',
            'codigo'             => 'required|string|max:255',
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
        

        // Crear la color con los datos validados
        $color = Color::create([
            'orden'              => $request->orden,
            'codigo'             => $request->codigo,
            'titulo'             => $request->titulo,
            'tituloen'          => $request->tituloen,
            'tituloport'          => $request->tituloport,
            'path'               => $imagePath,
        ]);

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('colores.dashboard')->with('message', 'Color creado exitosamente');
    }
    public function update(Request $request, $id)
    {

        // Validar los campos del formulario
        $validator = Validator::make($request->all(), [
            'orden'                => 'nullable|string|max:255',
            'codigo'             => 'nullable|string|max:255',
            'titulo'               => 'nullable|string|max:255',
            'tituloen'            => 'nullable|string|max:255',
            'tituloport'            => 'nullable|string|max:255',
            'path'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        // Obtener el registro de Colores
        $color = Color::findOrFail($id);
        
        
        if ($request->hasFile('path')) {
            $ruta= $color->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath=$file->store('images');
            
        }
        
        $color->orden      = $request->orden;
        $color->codigo     = $request->codigo;
        $color->titulo     = $request->titulo;
        $color->tituloen   = $request->tituloen;
        $color->tituloport = $request->tituloport;
        $color->path       = $imagePath ?? $color->path; // Mantener la imagen anterior si no se subió una nueva
        
        // Guardar los cambios en Colores
        $color->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('colores.dashboard')->with('message', 'Color actualizado exitosamente');
    }

    public function destroy($id)
    {
        // Find the Colores by id
        $color = Color::findOrFail($id);

        // Eliminar la imagen del almacenamiento si es necesario
        if ($color->path) {
            if (Storage::exists($color->path)) {
                Storage::delete($color->path);
            }
        }

        // Eliminar el registro de la base de datos
        $color->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('colores.dashboard')->with('message', 'Color eliminado exitosamente');
    }
}