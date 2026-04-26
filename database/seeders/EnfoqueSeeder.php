<?php

namespace Database\Seeders;

use App\Models\Enfoque;
use Illuminate\Database\Seeder;

class EnfoqueSeeder extends Seeder
{
  public function run(): void
  {
    $enfoques = [
      [
        'titulo'  => 'Busca tu propiedad',
        'enfoque' => 'Utiliza nuestro buscador inteligente para filtrar por zona, tipo y precio. Encuentra exactamente lo que necesitas en segundos.',
        'foto'    => null,
      ],
      [
        'titulo'  => 'Agenda una visita',
        'enfoque' => 'Contacta directamente al agente o usa nuestro formulario de cita. Coordinamos la visita según tu disponibilidad.',
        'foto'    => null,
      ],
      [
        'titulo'  => 'Recibe asesoría experta',
        'enfoque' => 'Nuestros asesores inmobiliarios te guían en cada detalle: financiamiento, documentación y negociación.',
        'foto'    => null,
      ],
      [
        'titulo'  => 'Concreta tu nuevo hogar',
        'enfoque' => 'Cierra la operación con total seguridad y transparencia. Te acompañamos hasta la entrega de llaves.',
        'foto'    => null,
      ],
    ];

    foreach ($enfoques as $enfoque) {
      Enfoque::updateOrCreate(
        ['titulo' => $enfoque['titulo']],
        $enfoque
      );
    }
  }
}
