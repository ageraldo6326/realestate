<?php

namespace Database\Seeders;

use App\Models\Zonas;
use Illuminate\Database\Seeder;

class ZonaSeeder extends Seeder
{
  public function run(): void
  {
    $zonas = [
      // Santo Domingo Este
      'Santo Domingo Este',
      'Los Mina',
      'Alma Rosa',
      'San Isidro',
      'Ensanche Ozama',
      'Sabana Perdida',
      'Villa Duarte',
      'La Victoria',
      'Los Tres Brazos',
      'Boca Chica',

      // Santo Domingo Norte
      'Santo Domingo Norte',
      'Villa Mella',
      'Guaricano',
      'Los Alcarrizos',
      'Pedro Brand',

      // Distrito Nacional
      'Distrito Nacional',
      'Piantini',
      'Naco',
      'Evaristo Morales',
      'La Julia',
      'Bella Vista',
      'Gazcue',
      'Ciudad Nueva',
      'Serralles',
      'Los Prados',
      'Mirador Norte',
      'Mirador Sur',
      'Arroyo Hondo',
      'Los Cacicazgos',
      'La Esperilla',
      'El Millón',

      // Santo Domingo Oeste
      'Santo Domingo Oeste',
      'Herrera',
      'Manoguayabo',

      // Zonas turísticas / interior
      'Bávaro',
      'Punta Cana',
      'Cap Cana',
      'Uvero Alto',
      'La Romana',
      'Casa de Campo',
      'Juan Dolio',
      'Santiago de los Caballeros',
      'Puerto Plata',
      'Samaná',
      'Las Terrenas',
    ];

    foreach ($zonas as $zona) {
      Zonas::firstOrCreate(['zona' => $zona]);
    }
  }
}
