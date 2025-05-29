<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderby('orden', 'asc')->get();
        foreach ($sliders as $slider) {    
            $slider->path = Storage::url($slider->path);
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path); 
        return inertia('Admin/Slider', [
            'sliders' => $sliders,
            'logo' => $logo
        ]);
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'path' => 'required|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov|max:100000',
            'titulo' => 'required|string|max:255',
            'tituloen' => 'nullable|string|max:255',
            'tituloport' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'descripcionen' => 'nullable|string|max:255',
            'descripcionport' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $filePath = null;
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $filePath=$file->store('images');
        } 

        // Crear el slider con los datos validados
        $slider = Slider::create([
            'orden' => $request->orden,
            'path' => $filePath,
            'titulo' => $request->titulo,
            'tituloen' => $request->tituloen,
            'tituloport' => $request->tituloport,
            'descripcion' => $request->descripcion,
            'descripcionen' => $request->descripcionen,
            'descripcionport' => $request->descripcionport,
        ]);

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('slider.dashboard')->with('message', 'Slider creado exitosamente');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return response()->json($slider);
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'path' => 'nullable|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov|max:100000',
            'titulo' => 'required|string|max:255',
            'tituloen' => 'nullable|string|max:255',
            'tituloport' => 'nullable|string|max:255',
            'descripcion' => 'required|string|max:255',
            'descripcionen' => 'nullable|string|max:255',
            'descripcionport' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Obtener el slider a actualizar
        $slider = Slider::findOrFail($id);

        if ($request->hasFile('path')) {
            $ruta= $slider->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath=$file->store('images');
            
        }

        // Actualizar los campos del slider
        $slider->orden = $request->input('orden');
        $slider->titulo = $request->input('titulo');
        $slider->tituloen = $request->input('tituloen');
        $slider->tituloport = $request->input('tituloport');
        $slider->descripcion = $request->input('descripcion');
        $slider->descripcionen = $request->input('descripcionen');
        $slider->descripcionport = $request->input('descripcionport');
        $slider->path = $imagePath ?? $slider->path; // Mantener la ruta anterior si no se subió una nueva imagen

        // Guardar los cambios en la base de datos
        $slider->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('slider.dashboard')->with('message', 'Slider editado exitosamente');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        // Eliminar la imagen del almacenamiento si es necesario
        if ($slider->path) {
            if (Storage::exists($slider->path)) {
                Storage::delete($slider->path);
            }
        }

        // Eliminar el registro de la base de datos
        $slider->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('slider.dashboard')->with('message', 'Slider eliminado exitosamente');
    }
}
