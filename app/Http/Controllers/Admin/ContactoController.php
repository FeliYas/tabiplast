<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contacto;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ContactoController extends Controller
{
    /**
     * Mostrar la página principal de contacto
     */
    public function index()
    {
        $contacto = Contacto::first();
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = asset('storage/' . $logo->path);
        $mapa = $contacto->iframe;

        return Inertia::render('Admin/Contacto', [
            'contacto' => $contacto,
            'logo' => $logo,
            'mapa' => $mapa
        ]);
    }

    /**
     * Actualizar la información de contacto
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'iframe' => 'nullable|string',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'banner' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:100000',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        $contacto = Contacto::findOrFail($id);

        // Handle banner upload
        if ($request->hasFile('banner')) {
            $ruta = $contacto->banner;
            $file = $request->file('banner');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath = $file->store('images');
            $contacto->banner = $imagePath;
        }

        $contacto->direccion = $request->direccion;
        $contacto->telefono = $request->telefono;
        $contacto->email = $request->email;
        $contacto->whatsapp = $request->whatsapp;
        $contacto->iframe = $request->iframe;
        $contacto->instagram = $request->instagram;
        $contacto->facebook = $request->facebook;
        $contacto->linkedin = $request->linkedin;

        $contacto->save();
        
        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('contacto.dashboard')->with('message', 'Contacto actualizado exitosamente');
    }
}
