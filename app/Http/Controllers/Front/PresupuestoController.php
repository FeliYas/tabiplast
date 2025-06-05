<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\PresupuestoMail;
use App\Models\Banner;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PresupuestoController extends Controller
{
    public function index()
    {
        $banner = Banner::where('seccion', 'presupuesto')->first();
        $banner->path = asset('storage/' . $banner->path);
        $logos = Logo::whereIn('seccion', ['navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $contactos = Contacto::select('direccion', 'email', 'telefono', 'facebook', 'instagram', 'linkedin')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        $productos = Producto::orderBy('orden', 'asc')->get();
        return view('front.presupuesto', compact('banner',  'logos', 'contactos', 'whatsapp', 'productos'));
    }
    public function enviar(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:100',
            'empresa' => 'nullable|string|max:100',
            'producto' => 'required|exists:productos,id',
            'cantidad' => 'nullable|integer|min:1',
            'mensaje' => 'nullable|string',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'g-recaptcha-response' => 'required'
        ]);

        // Verificar el token de reCAPTCHA
        $recaptcha = $this->verificarRecaptcha($request->input('g-recaptcha-response'));

        if (!$recaptcha['success']) {
            return redirect()->back()
                ->withErrors(['recaptcha' => 'La verificación de seguridad ha fallado. Por favor, inténtalo de nuevo.'])
                ->withInput();
        }

        // Si el score es muy bajo (posible bot), puedes rechazar la solicitud
        if ($recaptcha['score'] < 0.7) {
            return redirect()->back()
                ->withErrors(['recaptcha' => 'La verificación de seguridad ha detectado actividad sospechosa. Por favor, inténtalo de nuevo más tarde.'])
                ->withInput();
        }

        $contacto = Contacto::first()->email;


        if (!$contacto) {
            return redirect()->back()->with('error', 'No se encontró un contacto con el tipo "email".');
        }
        
        // Adjuntar archivo si existe
        if ($request->hasFile('archivo')) {
            $validated['archivo'] = $request->file('archivo');
        }

        // Enviar el correo
        Mail::to($contacto)->send(new PresupuestoMail($validated));
     
        // Redireccionar con mensaje de éxito
        return redirect()->back()->with('success', 'Mensaje enviado correctamente. Nos pondremos en contacto a la brevedad.');
    }
    private function verificarRecaptcha($token)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $token,
            'remoteip' => request()->ip()
        ]);

        return $response->json();
    }
}
