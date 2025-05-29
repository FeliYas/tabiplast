<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
     public function index()
    {
        $banners = Banner::orderby('orden', 'asc')->get();
        foreach ($banners as $banner) {
            $banner->path = Storage::url($banner->path);
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Banner', [
            'banners' => $banners,
            'logo' => $logo
        ]);
    }
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        $imagePath = null;
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $imagePath=$file->store('images');
        } 
        // Crear la banner con los datos validados
        $banner = Banner::create([
            'orden'              => $request->orden,
            'path'               => $imagePath,
        ]);

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('banners.dashboard')->with('message', 'Banner creado exitosamente');
    }
    public function update(Request $request, $id)
    {

        // Validar los campos del formulario
        $validator = Validator::make($request->all(), [
            'orden'                => 'nullable|string|max:255',
            'path'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        // Obtener el registro de banner
        $banner = Banner::findOrFail($id);

        if ($request->hasFile('path')) {
            $ruta= $banner->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath=$file->store('images');
            
        }

        $banner->orden              = $request->orden;
        $banner->path               = $imagePath ?? $banner->path;
        // Guardar los cambios en banner
        $banner->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('banners.dashboard')->with('message', 'Banner actualizado exitosamente');
    }

    public function destroy($id)
    {
        // Find the banner by id
        $banner = Banner::findOrFail($id);

        // Eliminar la imagen del almacenamiento si es necesario
        if ($banner->path) {
            if (Storage::exists($banner->path)) {
                Storage::delete($banner->path);
            }
        }

        // Eliminar el registro de la base de datos
        $banner->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('banners.dashboard')->with('message', 'Banner eliminado exitosamente');
    }
}
