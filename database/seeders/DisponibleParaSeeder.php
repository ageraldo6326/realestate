<?php

namespace Database\Seeders;

use App\Models\Disponible_para;
use Illuminate\Database\Seeder;

class DisponibleParaSeeder extends Seeder
{
  public function run(): void
  {
    $disponibles = [
      'En Venta',
      'En Alquiler',
      'En Alquiler con opción a compra',
      'En Permuta',
      'En Compra-Venta',
    ];

    foreach ($disponibles as $item) {
      Disponible_para::firstOrCreate(['disponible_para' => $item]);
    }
  }
}
