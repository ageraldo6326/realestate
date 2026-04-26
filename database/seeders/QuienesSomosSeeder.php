<?php

namespace Database\Seeders;

use App\Models\Inmobiliaria;
use Illuminate\Database\Seeder;

class QuienesSomosSeeder extends Seeder
{
  public function run(): void
  {
    $inmobiliaria = Inmobiliaria::first();

    if (!$inmobiliaria) {
      $inmobiliaria = new Inmobiliaria();
    }

    $inmobiliaria->fill([
      'quienessomos' => '<p>Somos una empresa inmobiliaria enfocada en conectar personas con propiedades que realmente encajan con su estilo de vida e inversion.</p><p>Combinamos acompanamiento cercano, analisis de mercado y procesos transparentes para compra, venta y alquiler en Santo Domingo y zonas turisticas.</p><p>Nuestro compromiso es ayudarte a tomar decisiones seguras, con informacion clara y asesoria profesional en cada etapa.</p>',
    ]);

    $inmobiliaria->save();
  }
}
