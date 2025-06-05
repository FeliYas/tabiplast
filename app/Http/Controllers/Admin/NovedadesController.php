<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
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
        $banner = Banner::where('seccion', 'novedades')->first();
        if ($banner) {
            $banner->path = Storage::url($banner->path);
        } else {
            $banner = null;
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Novedades', [
            'novedades' => $novedades,
            'logo' => $logo,
            'banner' => $banner,
        ]);
    }
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'orden'                => 'required|string|max:255',
            'epigrafe'            => 'nullable|string|max:255',
            'titulo'               => 'required|string|max:255',
            'descripcion'          => 'required|string',
            'especificaciones'     => 'nullable|string',
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
            'epigrafe'           => $request->epigrafe,
            'titulo'             => $request->titulo,
            'descripcion'        => $request->descripcion,
            'especificaciones'   => $request->especificaciones,
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
            'epigrafe'            => 'nullable|string|max:255',
            'titulo'               => 'nullable|string|max:255',
            'descripcion'          => 'nullable|string',
            'especificaciones'     => 'nullable|string',
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
        $novedades->epigrafe           = $request->epigrafe;
        $novedades->titulo             = $request->titulo;
        $novedades->descripcion        = $request->descripcion;
        $novedades->especificaciones   = $request->especificaciones;
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
    public function banner(Request $request, $id)
    {
        $validator = Validator::make(request()->all(), [
            'path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $banner = Banner::where('seccion', 'novedades')->findOrFail($id);

        if ($request->hasFile('path')) {
            $ruta = $banner->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            $imagePath = $file->store('images');
        }
        $banner->path = isset($imagePath) ? $imagePath : $banner->path;
        $banner->save();

        return redirect()->route('novedades.dashboard')->with('message', 'Banner actualizado exitosamente');
    }
}
