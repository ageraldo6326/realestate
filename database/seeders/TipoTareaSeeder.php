<?php

namespace Database\Seeders;

use App\Models\ToDoTipo;
use Illuminate\Database\Seeder;

class TipoTareaSeeder extends Seeder
{
  public function run(): void
  {
    $tipos = [
      ['todo_tipo' => 'Llamada telefónica',     'color' => '#3B82F6'],
      ['todo_tipo' => 'Reunión remota',          'color' => '#8B5CF6'],
      ['todo_tipo' => 'Cita presencial',         'color' => '#F59E0B'],
      ['todo_tipo' => 'Mostrar inmueble',        'color' => '#10B981'],
      ['todo_tipo' => 'Primer contacto',         'color' => '#06B6D4'],
      ['todo_tipo' => 'Seguimiento',             'color' => '#6366F1'],
      ['todo_tipo' => 'Envío de propuesta',      'color' => '#F97316'],
      ['todo_tipo' => 'Negociación',             'color' => '#EF4444'],
      ['todo_tipo' => 'Firma de contrato',       'color' => '#14532D'],
      ['todo_tipo' => 'Entrega de llaves',       'color' => '#065F46'],
      ['todo_tipo' => 'Cobro de cuota',          'color' => '#7C3AED'],
      ['todo_tipo' => 'Tarea administrativa',    'color' => '#6B7280'],
    ];

    foreach ($tipos as $tipo) {
      ToDoTipo::firstOrCreate(
        ['todo_tipo' => $tipo['todo_tipo']],
        ['color'     => $tipo['color']]
      );
    }
  }
}
