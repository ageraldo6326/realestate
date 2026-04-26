<?php

namespace Database\Seeders;

use App\Models\Testimonio;
use Illuminate\Database\Seeder;

class TestimonioSeeder extends Seeder
{
  public function run(): void
  {
    $testimonios = [
      [
        'testimonio'   => 'Encontré mi apartamento ideal en tiempo récord. El equipo me asesoró en cada paso del proceso y conseguí un precio excelente. ¡100% recomendado!',
        'cliente'      => 'María González',
        'cliente_foto' => 'cliente-1.jpg',
        'activo'       => true,
      ],
      [
        'testimonio'   => 'Vendí mi casa en menos de dos meses gracias a la difusión que le dieron a mi propiedad. El proceso fue transparente y sin sorpresas.',
        'cliente'      => 'Carlos Ramírez',
        'cliente_foto' => 'cliente-2.jpg',
        'activo'       => true,
      ],
      [
        'testimonio'   => 'Como inversor, valoro la seriedad y el conocimiento del mercado que tiene este equipo. Ya he cerrado tres operaciones con ellos y seguiré confiando en su trabajo.',
        'cliente'      => 'Luisa Fernández',
        'cliente_foto' => 'cliente-3.jpg',
        'activo'       => true,
      ],
    ];

    foreach ($testimonios as $testimonio) {
      Testimonio::updateOrCreate(
        ['cliente' => $testimonio['cliente']],
        $testimonio
      );
    }
  }
}
