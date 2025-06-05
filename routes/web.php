<?php
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ColocacionController;
use App\Http\Controllers\Admin\ContactoController;
use App\Http\Controllers\Admin\ContenidoController;
use App\Http\Controllers\Admin\InternacionalController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\MetadatoController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\NosotrosController;
use App\Http\Controllers\Admin\NovedadesController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProductoImgController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Front\ContactoController as FrontContactoController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\InternacionalController as FrontInternacionalController;
use App\Http\Controllers\Front\NosotrosController as FrontNosotrosController;
use App\Http\Controllers\Front\NovedadesController as FrontNovedadesController;
use App\Http\Controllers\Front\PresupuestoController;
use App\Http\Controllers\Front\ProductosController;
use App\Models\Logo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nosotros', [FrontNosotrosController::class, 'index'])->name('nosotros');
Route::get('/productos', [ProductosController::class, 'index'])->name('categorias');
Route::get('/productos/{id}', [ProductosController::class, 'show'])->name('productos');
Route::get('/producto/{id}', [ProductosController::class, 'showProducto'])->name('producto');
Route::get('/internacional', [FrontInternacionalController::class, 'index'])->name('internacional');
Route::get('/novedades', [FrontNovedadesController::class, 'index'])->name('novedades');
Route::get('/novedades/{id}', [FrontNovedadesController::class, 'show'])->name('novedad');
Route::get('/contacto', [FrontContactoController::class, 'index'])->name('contacto');
Route::post('/contacto/enviar', [FrontContactoController::class, 'enviar'])->name('contacto.enviar');
Route::get('/presupuesto', [PresupuestoController::class, 'index'])->name('presupuesto');
Route::post('/presupuesto/enviar', [PresupuestoController::class, 'enviar'])->name('presupuesto.enviar');
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

    //rutas de las nosotros del dashboard// Rutas para el controlador de Nosotros
Route::get('/admin/nosotros', [NosotrosController::class, 'index'])->name('nosotros.dashboard');
Route::post('/admin/nosotros/update/{id}', [NosotrosController::class, 'update'])->name('nosotros.update');
Route::put('/admin/nosotros/tarjeta/update/{id}', [NosotrosController::class, 'updateTarjeta'])->name('tarjeta.update');

    //rutas de los categorias del dashboard
    Route::get('/admin/productos/categorias', [CategoriaController::class, 'index'])->name('categorias.dashboard');
    Route::post('/admin/productos/categorias/banner/{id}', [CategoriaController::class, 'banner'])->name('categorias.banner');
    Route::post('/admin/productos/categorias/store', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::put('/admin/productos/categorias/update/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/admin/productos/categorias/destroy/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
    Route::post('/admin/productos/categorias/destacado', [CategoriaController::class, 'toggleDestacado'])->name('categorias.toggleDestacado');

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
    Route::get('/admin/productos/productos/colocacion/{id}', [ColocacionController::class, 'index'])->name('colocacion.dashboard');
    Route::post('/admin/productos/productos/colocacion/store', [ColocacionController::class, 'store'])->name('colocacion.store');
    Route::put('/admin/productos/productos/colocacion/update/{id}', [ColocacionController::class, 'update'])->name('colocacion.update');
    Route::delete('/admin/productos/productos/colocacion/delete/{id}', [ColocacionController::class, 'destroy'])->name('colocacion.destroy');

Route::get('/admin/internacional', [InternacionalController::class, 'index'])->name('internacional.dashboard');
Route::post('/admin/internacional/update/{id}', [InternacionalController::class, 'update'])->name('internacional.update');

    //rutas de las novedades del dashboard
    Route::get('/admin/novedades', [NovedadesController::class, 'index'])->name('novedades.dashboard');
    Route::post('/admin/novedades/banner/{id}', [NovedadesController::class, 'banner'])->name('novedades.banner');
    Route::post('/admin/novedades/store', [NovedadesController::class, 'store'])->name('novedades.store');
    Route::put('/admin/novedades/update/{id}', [NovedadesController::class, 'update'])->name('novedades.update');
    Route::delete('/admin/novedades/destroy/{id}', [NovedadesController::class, 'destroy'])->name('novedades.destroy');

    //rutas del contacto del dashboard
    Route::get('/admin/contacto', [ContactoController::class, 'index'])->name('contacto.dashboard');
    Route::post('/admin/contacto/update/{id}', [ContactoController::class, 'update'])->name('contacto.update');
    
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
