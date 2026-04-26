<?php

namespace Database\Seeders;

use App\Models\TiposDePropiedad;
use Illuminate\Database\Seeder;

class TipoPropiedadSeeder extends Seeder
{
  public function run(): void
  {
    $tipos = [
      'Apartamento',
      'Casa',
      'Villa',
      'Penthouse',
      'Estudio',
      'Local comercial',
      'Oficina',
      'Nave industrial',
      'Solar / Terreno',
      'Finca',
      'Proyecto turístico',
      'Bungalow',
      'Townhouse',
      'Duplex',
      'Edificio',
    ];

    foreach ($tipos as $tipo) {
      TiposDePropiedad::firstOrCreate(['tipo' => $tipo]);
    }
  }
}
