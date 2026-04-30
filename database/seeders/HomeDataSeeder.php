<?php

namespace Database\Seeders;

use Database\Seeders\DemoAdvisorSeeder;
use Illuminate\Database\Seeder;

/**
 * HomeDataSeeder
 *
 * Siembra todos los datos necesarios para visualizar el home del portal:
 *  - Portada (hero section)
 *  - Enfoques (cómo funciona)
 *  - Testimonios
 *  - Posts (blog)
 *  - Propiedades destacadas
 *
 * Prerequisito: el DatabaseSeeder debe haber ejecutado antes los catálogos
 * (zonas, tipos, disponibles_para, estados, provincias, inmobiliaria).
 *
 * Uso independiente:
 *   php artisan db:seed --class=HomeDataSeeder
 */
class HomeDataSeeder extends Seeder
{
  public function run(): void
  {
    $this->call([
      CatalogosSeeder::class,
      EmpresaSeeder::class,
      ContactoEmpresaSeeder::class,
      DemoAdvisorSeeder::class,
      QuienesSomosSeeder::class,
      PortadaSeeder::class,
      EnfoqueSeeder::class,
      TestimonioSeeder::class,
      PostSeeder::class,
      PropiedadSeeder::class,
    ]);
  }
}
