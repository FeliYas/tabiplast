<?php

namespace Database\Seeders;

use App\Models\Calidad;
use App\Models\Contacto;
use App\Models\Contenido;
use App\Models\Internacional;
use App\Models\Logo;
use App\Models\Metadato;
use App\Models\Nosotros;
use App\Models\Tarjeta;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios
        User::create([
            'name' => 'Pablo',
            'email' => 'pablo@tabiplast.com',
            'password' => Hash::make('pablopablo'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Usuario Normal',
            'email' => 'usuario@tabiplast.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Crear logos para las secciones
        $logoSecciones = ['login', 'dashboard', 'footer', 'navbar', 'home'];
        foreach ($logoSecciones as $seccion) {
            Logo::create([
                'path' => "logos/{$seccion}-logo.png",
                'seccion' => $seccion,
            ]);
        }

        // Crear metadatos para las secciones
        $metadatos = [
            [
                'seccion' => 'home',
                'keyword' => 'tabiplast, inicio, productos plásticos',
                'descripcion' => 'Página principal de Tabiplast - Empresa líder en productos plásticos de alta calidad'
            ],
            [
                'seccion' => 'nosotros',
                'keyword' => 'empresa, historia, tabiplast, quienes somos',
                'descripcion' => 'Conoce más sobre Tabiplast, nuestra historia y compromiso con la calidad'
            ],
            [
                'seccion' => 'productos',
                'keyword' => 'productos plásticos, catálogo, tabiplast',
                'descripcion' => 'Catálogo completo de productos plásticos de alta calidad de Tabiplast'
            ],
            [
                'seccion' => 'internacional',
                'keyword' => 'exportación, mercado internacional, tabiplast',
                'descripcion' => 'Presencia internacional de Tabiplast en mercados globales'
            ],
            [
                'seccion' => 'novedades',
                'keyword' => 'noticias, novedades, actualizaciones tabiplast',
                'descripcion' => 'Últimas noticias y novedades de Tabiplast'
            ],
            [
                'seccion' => 'contacto',
                'keyword' => 'contacto, ubicación, teléfono, email tabiplast',
                'descripcion' => 'Información de contacto y ubicación de Tabiplast'
            ]
        ];

        foreach ($metadatos as $metadato) {
            Metadato::create($metadato);
        }

        // Crear datos de ejemplo para nosotros
        Nosotros::create([
            'path' => 'images/nosotros-banner.jpg',
            'titulo' => 'Sobre Tabiplast',
            'descripcion' => 'Somos una empresa líder en la fabricación de productos plásticos de alta calidad, comprometidos con la innovación y la excelencia.',
            'video' => 'videos/nosotros-presentacion.mp4',
        ]);

        // Crear tarjetas de ejemplo
        $tarjetas = [
            [
                'path' => 'images/tarjeta-productos.jpg',
                'titulo' => 'Productos de Calidad',
                'descripcion' => 'Fabricamos productos plásticos con los más altos estándares de calidad y durabilidad.'
            ],
            [
                'path' => 'images/tarjeta-innovacion.jpg',
                'titulo' => 'Innovación Constante',
                'descripcion' => 'Invertimos en tecnología de punta para ofrecer soluciones innovadoras a nuestros clientes.'
            ],
            [
                'path' => 'images/tarjeta-servicio.jpg',
                'titulo' => 'Servicio Excepcional',
                'descripcion' => 'Nuestro equipo está comprometido con brindar el mejor servicio al cliente.'
            ]
        ];

        foreach ($tarjetas as $tarjeta) {
            Tarjeta::create($tarjeta);
        }

        // Crear contenido de ejemplo
        Contenido::create([
            'path' => 'images/contenido-home-banner.jpg',
            'titulo' => 'Bienvenidos a Tabiplast',
            'descripcion' => 'Tu socio confiable en soluciones plásticas de alta calidad para todas las industrias.'
        ]);

        // Crear datos internacionales
        Internacional::create([
            'path' => 'images/internacional-global.jpg',
            'titulo' => 'Presencia Internacional',
            'descripcion' => 'Exportamos nuestros productos a más de 15 países en América Latina, Europa y Asia, consolidando nuestra presencia global con distribuidores especializados y alianzas estratégicas.'
        ]);
    }
}
