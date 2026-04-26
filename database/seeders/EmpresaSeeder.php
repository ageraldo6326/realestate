<?php

namespace Database\Seeders;

use App\Models\Inmobiliaria;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
  public function run(): void
  {
    $inmobiliaria = Inmobiliaria::first();

    if (!$inmobiliaria) {
      $inmobiliaria = new Inmobiliaria();
    }

    $inmobiliaria->fill([
      'nombre' => 'RealEstate Demo',
      'titulo' => 'Inmobiliaria en Santo Domingo para Compra, Venta y Alquiler',
      'metadescription' => 'Portal inmobiliario para compra, venta y alquiler en Santo Domingo y zonas turisticas de Republica Dominicana.',
      'slogan' => 'Tu proximo inmueble comienza aqui',
      'palabrasclaves' => 'inmobiliaria santo domingo, apartamentos, casas, alquiler, venta, bienes raices',
      'logo' => 'inmobiliaria/logo.png',
      'favicon' => 'inmobiliaria/favicon.ico',
      'dominio' => 'http://realestate.local/',
      'aprobacion' => 1,
    ]);

    $inmobiliaria->save();
  }
}
