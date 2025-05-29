<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contenido;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ContenidoController extends Controller
{
    public function index()
    {
        $contenido = Contenido::take(2)->get();
        foreach ($contenido as $cont) {
            $cont->path = Storage::url($cont->path);
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Contenido', [
            'contenido' => $contenido,
            'logo' => $logo
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'nullable|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov|max:100000',
            'titulo' => 'nullable|string|max:255',
            'tituloen' => 'nullable|string|max:255',
            'tituloport' => 'nullable|string|max:255',
            'descripcion' => 'nullable|required',
            'descripcionen' => 'nullable|required',
            'descripcionport' => 'nullable|required',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        
        $contenido = Contenido::findOrFail($id);

        if ($request->hasFile('path')) {
            $ruta= $contenido->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath=$file->store('images');
            
        }

        $contenido->titulo = $request->titulo;
        $contenido->tituloen = $request->tituloen;
        $contenido->tituloport = $request->tituloport;
        $contenido->descripcion = $request->descripcion;
        $contenido->descripcionen = $request->descripcionen;
        $contenido->descripcionport = $request->descripcionport;
        $contenido->path = $imagePath ?? $contenido->path;

        $contenido->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('contenido.dashboard')->with('message', 'Contenido actualizado exitosamente');
    }
}
