<?php

use App\Http\Controllers\Admin\AplicacionesController;
use App\Http\Controllers\Admin\AplicacionProductoController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CalidadController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ContactoController;
use App\Http\Controllers\Admin\ContenidoController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\MetadatoController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\NosotrosController;
use App\Http\Controllers\Admin\NovedadesController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProductoImgController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Front\AplicacionesController as FrontAplicacionesController;
use App\Http\Controllers\Front\CalidadController as FrontCalidadController;
use App\Http\Controllers\Front\ColorController as FrontColorController;
use App\Http\Controllers\Front\ContactoController as FrontContactoController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\NosotrosController as FrontNosotrosController;
use App\Http\Controllers\Front\NovedadesController as FrontNovedadesController;
use App\Http\Controllers\Front\ProductosController;
use App\Models\Logo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nosotros', [FrontNosotrosController::class, 'index'])->name('nosotros');
Route::get('/productos/{id?}', [ProductosController::class, 'index'])->name('productos');
Route::get('/producto/{id}', [ProductosController::class, 'show'])->name('producto');
Route::get('/aplicaciones', [FrontAplicacionesController::class, 'index'])->name('aplicaciones');
Route::get('/aplicaciones/{id}', [FrontAplicacionesController::class, 'show'])->name('aplicacion');
Route::get('/carta-de-colores', [FrontColorController::class, 'index'])->name('colores');
Route::get('/calidad', [FrontCalidadController::class, 'index'])->name('calidad');
Route::get('/novedades', [FrontNovedadesController::class, 'index'])->name('novedades');
Route::get('/novedades/{id}', [FrontNovedadesController::class, 'show'])->name('novedad');
Route::get('/contacto', [FrontContactoController::class, 'index'])->name('contacto');
Route::post('/contacto/enviar', [FrontContactoController::class, 'enviar'])->name('contacto.enviar');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/adm', function () {
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return Inertia::render('Admin/Dashboard', [
            'logo' => $logo,
        ]);
    })->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/admin/home/slider', [SliderController::class, 'index'])->name('slider.dashboard');
    Route::post('/admin/home/slider/store', [SliderController::class, 'store'])->name('slider.store');
    Route::post('/admin/home/slider/update/{id}', [SliderController::class, 'update'])->name('slider.update');
    Route::delete('/admin/home/slider/delete/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    
    //rutas de los contenidos del dashboard
    Route::get('/admin/home/contenido', [ContenidoController::class, 'index'])->name('contenido.dashboard');
    Route::post('/admin/home/contenido/update/{id}', [ContenidoController::class, 'update'])->name('contenido.update');

    //rutas de las nosotros del dashboard
    Route::get('/admin/nosotros/banner', [BannerController::class, 'index'])->name('banners.dashboard');
    Route::post('/admin/nosotros/banner/create', [BannerController::class, 'store'])->name('banner.store');
    Route::put('/admin/nosotros/banner/update/{id}', [BannerController::class, 'update'])->name('banner.update');
    Route::delete('/admin/nosotros/banner/delete/{id}', [BannerController::class, 'destroy'])->name('banner.destroy');
    Route::get('/admin/nosotros', [NosotrosController::class, 'index'])->name('nosotros.dashboard');
    Route::post('/admin/nosotros/update/{id}', [NosotrosController::class, 'update'])->name('nosotros.update');

    //rutas de los categorias del dashboard
    Route::get('/admin/productos/categorias', [CategoriaController::class, 'index'])->name('categorias.dashboard');
    Route::post('/admin/productos/categorias/store', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::put('/admin/productos/categorias/update/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/admin/productos/categorias/destroy/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
    

    //rutas de los productos del dashboard
    Route::get('/admin/productos/productos', [ProductoController::class, 'index'])->name('productos.dashboard');
    Route::post('/admin/productos/productos/store', [ProductoController::class, 'store'])->name('productos.store');
    Route::put('/admin/productos/productos/update/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/admin/productos/productos/delete/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    Route::post('/admin/productos/productos/destacado', [ProductoController::class, 'toggleDestacado'])->name('productos.toggleDestacado');
    Route::get('/admin/productos/productos/imagenes/{id}', [ProductoImgController::class, 'index'])->name('imagenes.dashboard');
    Route::post('/admin/productos/productos/imagenes/store', [ProductoImgController::class, 'store'])->name('imagenes.store');
    Route::put('/admin/productos/productos/imagenes/update/{id}', [ProductoImgController::class, 'update'])->name('imagenes.update');
    Route::delete('/admin/productos/productos/imagenes/delete/{id}', [ProductoImgController::class, 'destroy'])->name('imagenes.destroy');
    
    //rutas de aplicaciones del dashboard
    Route::get('/admin/aplicaciones', [AplicacionesController::class, 'index'])->name('aplicaciones.dashboard');
    Route::post('/admin/aplicaciones/store', [AplicacionesController::class, 'store'])->name('aplicaciones.store');
    Route::put('/admin/aplicaciones/update/{id}', [AplicacionesController::class, 'update'])->name('aplicaciones.update');
    Route::delete('/admin/aplicaciones/delete/{id}', [AplicacionesController::class, 'destroy'])->name('aplicaciones.destroy');
    Route::get('/admin/aplicaciones/relacionados/{id}', [AplicacionProductoController::class, 'index'])->name('relacionados.dashboard'); 
    Route::post('/admin/aplicaciones/relacionados/store', [AplicacionProductoController::class, 'store'])->name('relacionados.store');
    Route::delete('/admin/aplicaciones/relacionados/delete/{id}', [AplicacionProductoController::class, 'destroy'])->name('relacionados.destroy');

    //rutas de colores del dashboard
    Route::get('/admin/colores', [ColorController::class, 'index'])->name('colores.dashboard');
    Route::post('/admin/colores/store', [ColorController::class, 'store'])->name('colores.store');
    Route::put('/admin/colores/update/{id}', [ColorController::class, 'update'])->name('colores.update');
    Route::delete('/admin/colores/delete/{id}', [ColorController::class, 'destroy'])->name('colores.destroy');

    //rutas de calidad del dashboard
    Route::get('/admin/calidad', [CalidadController::class, 'index'])->name('calidad.dashboard');
    Route::post('/admin/calidad/update/{id}', [CalidadController::class, 'update'])->name('calidad.update');

    //rutas de las novedades del dashboard
    Route::get('/admin/novedades', [NovedadesController::class, 'index'])->name('novedades.dashboard');
    Route::post('/admin/novedades/store', [NovedadesController::class, 'store'])->name('novedades.store');
    Route::put('/admin/novedades/update/{id}', [NovedadesController::class, 'update'])->name('novedades.update');
    Route::delete('/admin/novedades/destroy/{id}', [NovedadesController::class, 'destroy'])->name('novedades.destroy');

    //rutas del contacto del dashboard
    Route::get('/admin/contacto', [ContactoController::class, 'index'])->name('contacto.dashboard');
    Route::put('/admin/contacto/update/{id}', [ContactoController::class, 'update'])->name('contacto.update');
    
    //rutas de los logos del dashboard
    Route::get('/admin/logos', [LogoController::class, 'index'])->name('logos.dashboard');
    Route::put('/admin/logos/update/{id}', [LogoController::class, 'update'])->name('logos.update');

    //rutas del newsletter del dashboard
    Route::get('/admin/newsletter', [NewsletterController::class, 'index'])->name('newsletter.dashboard');
    Route::delete('/admin/newsletter/destroy/{id}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');

    //rutas de usuarios del dashboard
    Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('usuarios.dashboard');
    Route::post('/admin/usuarios/create', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::put('/admin/usuarios/edit/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/admin/usuarios/delete/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    //rutas de los metadatos
    Route::get('/admin/metadatos', [MetadatoController::class, 'index'])->name('metadatos.dashboard');
    Route::put('/admin/metadatos/update/{id}', [MetadatoController::class, 'update'])->name('metadatos.update');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
