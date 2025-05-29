<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use App\Models\Producto;
use App\Models\ProductoImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductoImgController extends Controller
{
    public function index($id)
    {
        $producto = Producto::findOrFail($id);
        $imagenes = ProductoImg::where('producto_id', $id)->orderBy('orden', 'asc')->get();
        foreach ($imagenes as $imagen) {
            $imagen->path = Storage::url($imagen->path);
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Imagenes', [
            'imagenes' => $imagenes,
            'producto' => $producto,
            'logo' => $logo
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'producto_id' => 'required|exists:productos,id',
            'path' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'orden' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        
        $imagePath = null;
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $imagePath=$file->store('images');
        } 

        $imagen = ProductoImg::create([
            'orden'              => $request->orden,
            'path'               => $imagePath,
            'producto_id'        => $request->producto_id,
        ]);
        
        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('imagenes.dashboard', ['id' => $request->producto_id])->with('message', 'Imagen agregada exitosamente');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'orden' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $productoImg = ProductoImg::findOrFail($id);

        if ($request->hasFile('path')) {
            $ruta= $productoImg->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath=$file->store('images');
            
        }
        // Solo se actualizan los campos si el request contiene un valor
        $productoImg->update(array_filter([
            'orden' => $request->orden,
            'path' => $imagePath ?? $productoImg->path,
        ]));
        
        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('imagenes.dashboard', ['id' => $productoImg->producto_id])->with('message', 'Imagen actualizada exitosamente');
    }
    public function destroy($id)
    {
        $imagen = ProductoImg::findOrFail($id);

        // Eliminar la imagen del almacenamiento si es necesario
        if ($imagen->path) {
            if (Storage::exists($imagen->path)) {
                Storage::delete($imagen->path);
            }
        }
        $imagen->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('imagenes.dashboard', ['id' => $imagen->producto_id])->with('message', 'Imagen eliminada exitosamente');
    }
}
