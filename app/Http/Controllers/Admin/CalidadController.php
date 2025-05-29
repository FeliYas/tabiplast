<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Calidad;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CalidadController extends Controller
{
    public function index()
    {
        $calidad = Calidad::first();
        $calidad->path = Storage::url($calidad->path);
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Calidad', [
            'calidad' => $calidad,
            'logo' => $logo,
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'nullable|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov|max:100000',
            'titulo' => 'nullable|string',
            'tituloen' => 'nullable|string',
            'tituloport' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'descripcionen' => 'nullable|string',
            'descripcionport' => 'nullable|string',
            'iso1' => 'nullable|mimes:pdf|max:100000',
            'iso2' => 'nullable|mimes:pdf|max:100000',
        ]);
        
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $calidad = Calidad::findOrFail($id);

        if ($request->hasFile('path')) {
            $ruta = $calidad->path;
            $file = $request->file('path');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath = $file->store('images');
            
        }
        
        if ($request->hasFile('iso1')) {
            $ruta = $calidad->iso1;
            $file = $request->file('iso1');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $iso1Path = $file->store('fichas');
            
        }

        if ($request->hasFile('iso2')) {
            $ruta = $calidad->iso2;
            $file = $request->file('iso2');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $iso2Path = $file->store('fichas');
             }
        
        $calidad->titulo = $request->titulo;
        $calidad->tituloen = $request->tituloen;
        $calidad->tituloport = $request->tituloport;
        $calidad->descripcion = $request->descripcion;
        $calidad->descripcionen = $request->descripcionen;
        $calidad->descripcionport = $request->descripcionport;
        $calidad->path = $imagePath ?? $calidad->path;
        $calidad->iso1 = $iso1Path ?? $calidad->iso1;
        $calidad->iso2 = $iso2Path ?? $calidad->iso2;

        $calidad->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('calidad.dashboard')->with('message', 'Calidad actualizado exitosamente');
    }
}
