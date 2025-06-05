<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Categoria;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('orden', 'asc')->get();
        foreach ($categorias as $categoria) {
            if ($categoria->path) {
                $categoria->path = Storage::url($categoria->path);
            }
        }
        $banner = Banner::where('seccion', 'categorias')->first();
        if ($banner) {
            $banner->path = Storage::url($banner->path);
        } else {
            $banner = null;
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Categorias', [
            'categorias' => $categorias,
            'logo' => $logo,
            'banner' => $banner,
        ]);
    }
    public function banner(Request $request, $id)
    {
        $validator = Validator::make(request()->all(), [
            'path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $banner = Banner::findOrFail($id);

        if ($request->hasFile('path')) {
            $ruta= $banner->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath=$file->store('images');
            
        }
        $banner->path = isset($imagePath) ? $imagePath : $banner->path;
        $banner->save();

        return redirect()->route('categorias.dashboard')->with('message', 'Banner actualizado exitosamente');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'titulo' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

         $imagePath = null;
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $imagePath=$file->store('images');
        } 

        // Crear la categoria con los datos validados
        $categoria = Categoria::create([
            'orden'              => $request->orden,
            'path'               => $imagePath,
            'titulo'             => $request->titulo,
        ]);

            // Redireccionar al index con un mensaje de éxito
            return redirect()->route('categorias.dashboard')->with('message', 'Categoria creada exitosamente');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'orden' => 'nullable|string|max:255',
            'path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'titulo' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        
        $categoria = Categoria::findOrFail($id);

        if ($request->hasFile('path')) {
            $ruta= $categoria->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath=$file->store('images');
            
        }

        $categoria->titulo = $request->titulo;
        $categoria->orden = $request->orden;
        $categoria->path = isset($imagePath) ? $imagePath : $categoria->path; 

        $categoria->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('categorias.dashboard')->with('message', 'Categoria actualizada exitosamente');
    }
    public function destroy($id)
    {
        // Find the Categoria by id
        $categoria = Categoria::findOrFail($id);

        if ($categoria->path) {
            if (Storage::exists($categoria->path)) {
                Storage::delete($categoria->path);
            }
        }

        // Eliminar el registro de la base de datos
        $categoria->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('categorias.dashboard')->with('message', 'Categoria eliminada exitosamente');
    }
    public function toggleDestacado(Request $request)
    {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->destacado = $request->destacado ? 1 : 0;
        $categoria->save();

        return redirect()->route('categorias.dashboard')->with('message', 'Categoria destacada exitosamente');
    }
}
