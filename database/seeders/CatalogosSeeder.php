<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * CatalogosSeeder
 *
 * Siembra todos los catálogos base del sistema (idempotente con firstOrCreate).
 *
 * Uso:
 *   php artisan db:seed --class=CatalogosSeeder
 */
class CatalogosSeeder extends Seeder
{
  public function run(): void
  {
    $this->call([
      ProvinciaSeeder::class,
      ZonaSeeder::class,
      TipoPropiedadSeeder::class,
      EstadoPropiedadSeeder::class,
      DisponibleParaSeeder::class,
      TipoTareaSeeder::class,
      ClienteSeeder::class,
    ]);
  }
}
