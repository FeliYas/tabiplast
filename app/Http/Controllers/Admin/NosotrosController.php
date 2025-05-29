<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use App\Models\Nosotros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NosotrosController extends Controller
{
    public function index()
    {
        $nosotros = Nosotros::first();
        $nosotros->path = Storage::url($nosotros->path);   
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Nosotros', [
            'nosotros' => $nosotros,
            'logo' => $logo,
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'nullable|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov|max:100000',
            'descripcion' => 'nullable|string',
            'descripcionen' => 'nullable|string',
            'descripcionport' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $nosotros = Nosotros::findOrFail($id);

       

        if ($request->hasFile('path')) {
            $ruta= $nosotros->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath=$file->store('images');
            
        }

        $nosotros->descripcion = $request->descripcion;
        $nosotros->descripcionen = $request->descripcionen;
        $nosotros->descripcionport = $request->descripcionport;
        $nosotros->path = $imagePath ?? $nosotros->path;

        $nosotros->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('nosotros.dashboard')->with('message', 'Nosotros actualizado exitosamente');
    }
}
