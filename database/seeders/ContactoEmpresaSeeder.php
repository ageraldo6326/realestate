<?php

namespace Database\Seeders;

use App\Models\Inmobiliaria;
use Illuminate\Database\Seeder;

class ContactoEmpresaSeeder extends Seeder
{
  public function run(): void
  {
    $inmobiliaria = Inmobiliaria::first();

    if (!$inmobiliaria) {
      $inmobiliaria = new Inmobiliaria();
    }

    $inmobiliaria->fill([
      'correo' => 'contacto@realestate.local',
      'telefono' => '809-555-0101',
      'direccion' => 'Av. Winston Churchill 123, Piantini, Santo Domingo, RD',
      'facebook' => 'https://facebook.com/realestate.demo',
      'instagram' => 'https://instagram.com/realestate.demo',
      'tiktok' => 'https://tiktok.com/@realestate.demo',
      'whatsapp' => 'https://wa.me/18095550101',
    ]);

    $inmobiliaria->save();
  }
}
