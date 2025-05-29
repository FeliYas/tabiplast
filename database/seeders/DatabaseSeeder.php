<?php

namespace Database\Seeders;

use App\Models\Calidad;
use App\Models\Contacto;
use App\Models\Contenido;
use App\Models\Logo;
use App\Models\Metadato;
use App\Models\Nosotros;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

         User::create([
            'name' => 'Pablo',
            'email' => 'pablo@osole.com',
            'role' => 'admin',
            'password' => bcrypt('pablopablo')
        ]);
        User::create([
            'name' => 'Feli',
            'email' => 'Feli@osole.com',
            'password' => bcrypt('pablopablo')
        ]);
        Logo::create([
            'path' => 'images/logologin.png',
            'seccion' => 'login',
        ]);
        Logo::create([
            'path' => 'images/logohome.png',
            'seccion' => 'home',
        ]);
        Logo::create([
            'path' => 'images/logonavbar.png',
            'seccion' => 'navbar',
        ]);
        Logo::create([
            'path' => 'images/logofooter.png',
            'seccion' => 'footer',
        ]);
        Logo::create([
            'path' => 'images/logodashboard.png',
            'seccion' => 'dashboard',
        ]);
        Metadato::create([
            'seccion' => 'home',
            'keyword' => 'inicio, bienvenida, principal',
            'descripcion' => 'Sección principal de la página de inicio con información destacada.',
        ]);
        Metadato::create([
            'seccion' => 'nosotros',
            'keyword' => 'quiénes somos, empresa, equipo',
            'descripcion' => 'Sección que describe la historia, misión y valores de la empresa.',
        ]);
        Metadato::create([
            'seccion' => 'productos',
            'keyword' => 'catálogo, artículos, servicios',
            'descripcion' => 'Sección dedicada a mostrar los productos o servicios ofrecidos.',
        ]);
        Metadato::create([
            'seccion' => 'aplicaciones',
            'keyword' => 'uso, aplicaciones, ejemplos',
            'descripcion' => 'Sección que muestra ejemplos de uso o aplicaciones de los productos.',
        ]);
        Metadato::create([
            'seccion' => 'carta de colores',
            'keyword' => 'colores, opciones, personalización',
            'descripcion' => 'Sección que presenta la carta de colores disponible para los productos.',
        ]);
        Metadato::create([
            'seccion' => 'calidad',
            'keyword' => 'certificaciones, estándares, calidad',
            'descripcion' => 'Sección que detalla las certificaciones y estándares de calidad de los productos.',
        ]);
        Metadato::create([
            'seccion' => 'novedades',
            'keyword' => 'noticias, actualizaciones, blog',
            'descripcion' => 'Sección con las últimas noticias y actualizaciones de la empresa.',
        ]);
        Metadato::create([
            'seccion' => 'contacto',
            'keyword' => 'formulario, dirección, teléfono',
            'descripcion' => 'Sección con información de contacto y formulario para consultas.',
        ]);
        Contacto::create([
            'direccion' => 'Calle 129 2929 (ex, Carlos Gardel) B1651 Villa Libertad, Buenos Aires',
            'email' => 'info@industriarpc.com.ar',
            'telefono' => '011 6589-6064',
            'telefono2' => '011 6589-6064',
            'whatsapp' => '5491165896064',
            'iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3284.880932402293!2d-58.56170319359548!3d-34.58187921234347!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcb9d7ba676873%3A0xe9ab481b2dcbc7a9!2sIndustria%20R.P.C.!5e0!3m2!1ses-419!2sar!4v1744740555596!5m2!1ses-419!2sar" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'
        ]);
        Nosotros::create([
            'path' => 'images/nosotros.png',
            'descripcion' => 'Industria R.P.C. es una empresa dedicada a la fabricación de accesorios para sanitarios, comprometida con la calidad, la innovación y la satisfacción de nuestros clientes. Desde nuestros inicios, trabajamos con la premisa de ofrecer soluciones funcionales y duraderas que se adapten a las necesidades del mercado, combinando tecnología, diseño y materiales de alta resistencia. Nuestra misión es desarrollar y producir accesorios para sanitarios que mejoren la experiencia y el confort de los usuarios, garantizando altos estándares de calidad y eficiencia en cada uno de nuestros productos. Buscamos optimizar cada etapa del proceso productivo, apostando por la mejora continua y la sostenibilidad en nuestras prácticas industriales. Aspiramos a consolidarnos como una empresa referente en el sector, reconocida por la confiabilidad de nuestros productos y la innovación en el diseño y la funcionalidad de nuestros accesorios. Visualizamos un futuro en el que Industria R.P.C. sea sinónimo de excelencia, impulsando el desarrollo del rubro con propuestas que marquen la diferencia en el mercado.',
        ]);
        Contenido::create([
            'path' => 'images/contenido.png',
            'titulo' => 'Nosotros',
            'descripcion' => 'Industria R.P.C. es una empresa dedicada a la fabricación de accesorios para sanitarios, comprometida con la calidad, la innovación y la satisfacción de nuestros clientes. Desde nuestros inicios, trabajamos con la premisa de ofrecer soluciones funcionales y duraderas que se adapten a las necesidades del mercado, combinando tecnología, diseño y materiales de alta resistencia. Nuestra misión es desarrollar y producir accesorios para sanitarios que mejoren la experiencia y el confort de los usuarios, garantizando altos estándares de calidad y eficiencia en cada uno de nuestros productos. Buscamos optimizar cada etapa del proceso productivo, apostando por la mejora continua y la sostenibilidad en nuestras prácticas industriales.',
        ]);
        Contenido::create([
            'path' => 'images/contenido2.png',
            'titulo' => 'Nosotross',
            'descripcion' => 'Industria R.P.C. ess una empresa dedicada a la fabricación de accesorios para sanitarios, comprometida con la calidad, la innovación y la satisfacción de nuestros clientes. Desde nuestros inicios, trabajamos con la premisa de ofrecer soluciones funcionales y duraderas que se adapten a las necesidades del mercado, combinando tecnología, diseño y materiales de alta resistencia. Nuestra misión es desarrollar y producir accesorios para sanitarios que mejoren la experiencia y el confort de los usuarios, garantizando altos estándares de calidad y eficiencia en cada uno de nuestros productos. Buscamos optimizar cada etapa del proceso productivo, apostando por la mejora continua y la sostenibilidad en nuestras prácticas industriales.',
        ]);
        Calidad::create([
            'path' => 'images/calidad.png',
            'titulo' => 'Calidad',
            'descripcion' => 'Industria R.P.C. es una empresa dedicada a la fabricación de accesorios para sanitarios, comprometida con la calidad, la innovación y la satisfacción de nuestros clientes. Desde nuestros inicios, trabajamos con la premisa de ofrecer soluciones funcionales y duraderas que se adapten a las necesidades del mercado, combinando tecnología, diseño y materiales de alta resistencia. Nuestra misión es desarrollar y producir accesorios para sanitarios que mejoren la experiencia y el confort de los usuarios, garantizando altos estándares de calidad y eficiencia en cada uno de nuestros productos. Buscamos optimizar cada etapa del proceso productivo, apostando por la mejora continua y la sostenibilidad en nuestras prácticas industriales.',
        ]);
    }
}
