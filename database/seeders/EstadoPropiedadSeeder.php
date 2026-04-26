<?php

namespace Database\Seeders;

use App\Models\Estados;
use Illuminate\Database\Seeder;

class EstadoPropiedadSeeder extends Seeder
{
  public function run(): void
  {
    // varchar(15) — máx 15 caracteres por valor
    $estados = [
      'Nueva',
      'Usada',
      'En plano',
      'Mejora',
      'Remodelada',
      'Lista entregar',
    ];

    foreach ($estados as $estado) {
      Estados::firstOrCreate(['estado' => $estado]);
    }
  }
}
