<?php

namespace Database\Seeders;

use App\Models\Portada;
use Illuminate\Database\Seeder;

class PortadaSeeder extends Seeder
{
  public function run(): void
  {
    Portada::updateOrCreate(
      ['slug' => 'inicio'],
      [
        'minititulo'  => 'TU NUEVO COMIENZO, ESTÁ AQUÍ',
        'titulo'      => 'Encuentra el hogar que siempre soñaste',
        'descripcion' => 'Explora cientos de propiedades verificadas en venta y alquiler en las mejores ubicaciones de República Dominicana. Asesoría personalizada en cada paso.',
        'enlace1'     => 'Ver propiedades',
        'url1'        => '/propiedades',
        'enlace2'     => 'Contáctanos',
        'url2'        => '/contacto',
        'foto'        => 'portada-hero.jpg',
        'activo'      => true,
      ]
    );
  }
}
