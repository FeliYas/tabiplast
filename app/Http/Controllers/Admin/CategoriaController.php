<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Categorias', [
            'categorias' => $categorias,
            'logo' => $logo
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'tituloen' => 'required|string|max:255',
            'tituloport' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        // Crear la categoria con los datos validados
        $categoria = Categoria::create([
            'orden'              => $request->orden,
            'titulo'             => $request->titulo,
            'tituloen'          => $request->tituloen,
            'tituloport'          => $request->tituloport,
        ]);

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('categorias.dashboard')->with('message', 'Categoria creada exitosamente');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'orden' => 'nullable|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'tituloen' => 'nullable|string|max:255',
            'tituloport' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        $categoria = Categoria::findOrFail($id);
        $categoria->titulo = $request->titulo;
        $categoria->tituloen = $request->tituloen;
        $categoria->tituloport = $request->tituloport;
        $categoria->orden = $request->orden;

        $categoria->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('categorias.dashboard')->with('message', 'Categoria actualizada exitosamente');
    }
    public function destroy($id)
    {
        // Find the Categoria by id
        $categoria = Categoria::findOrFail($id);

        // Eliminar el registro de la base de datos
        $categoria->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('categorias.dashboard')->with('message', 'Categoria eliminada exitosamente');
    }
}
