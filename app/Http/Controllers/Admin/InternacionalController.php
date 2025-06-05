<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Internacional;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InternacionalController extends Controller
{
    public function index()
    {
        $internacional = Internacional::first();
        $internacional->path = Storage::url($internacional->path);
        // Mostrar el banner si existe
        $internacional->banner = $internacional->banner ? Storage::url($internacional->banner) : null;
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Internacional', [
            'internacional' => $internacional,
            'logo' => $logo,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'nullable|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov|max:100000',
            'banner' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:100000',
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator->messages()->first());
        }

        $internacional = Internacional::findOrFail($id);

        // Validar y procesar la imagen principal si se proporciona
        $imagePath = $internacional->path;
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            if (Storage::exists($internacional->path)) {
                Storage::delete($internacional->path);
            }
            $imagePath = $file->store('images');
        }

        // Validar y procesar el banner si se proporciona
        $bannerPath = $internacional->banner;
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            if (Storage::exists($internacional->banner)) {
                Storage::delete($internacional->banner);
            }
            $bannerPath = $file->store('images');
        }

        $internacional->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'path' => $imagePath,
            'banner' => $bannerPath,
        ]);

        return redirect()->route('internacional.dashboard')->with('message', 'Internacional actualizado exitosamente');
    }
}
