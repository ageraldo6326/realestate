<?php

namespace Database\Seeders;

use App\Models\Propiedad;
use App\Models\Zonas;
use App\Models\TiposDePropiedad;
use App\Models\Disponible_para;
use App\Models\Estados;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropiedadSeeder extends Seeder
{
  public function run(): void
  {
    // Recuperar IDs reales de las tablas relacionadas
    $zonaIds     = Zonas::pluck('id', 'zona');
    $tipoIds     = TiposDePropiedad::pluck('id', 'tipo');
    $disponibles = Disponible_para::pluck('id', 'disponible_para');
    $estadoIds   = Estados::pluck('id', 'estado');

    $zona1 = $zonaIds->get('Santo Domingo Este', $zonaIds->first());
    $zona2 = $zonaIds->get('Santo Domingo Norte', $zona1);
    $zona3 = $zonaIds->get('Bávaro', $zonaIds->get('Bavaro', $zona1));
    $zona4 = $zonaIds->get('Cap Cana', $zonaIds->get('Punta Cana', $zona1));

    $tipoApto  = $tipoIds->get('Apartamento', $tipoIds->first());
    $tipoCasa  = $tipoIds->get('Casa', $tipoIds->first());
    $tipoOficina = $tipoIds->get('Oficina', $tipoCasa);

    $enVenta    = $disponibles->get('En Venta', $disponibles->first());
    $enAlquiler = $disponibles->get('En Alquiler', $disponibles->first());

    $estadoNueva  = $estadoIds->get('Nueva', $estadoIds->first());
    $estadoUsada  = $estadoIds->get('Usada', $estadoIds->first());
    $estadoEnPlano = $estadoIds->get('En plano', $estadoIds->first());

    $advisorEmails = [
      'kelly@realestate.local',
      'lavinia@realestate.local',
      'mario@realestate.local',
    ];

    $advisors = User::query()
      ->whereIn('email', $advisorEmails)
      ->get()
      ->keyBy('email');

    $fallbackAdvisor = User::query()->where('email', 'admin@realestate.local')->first();

    $advisorFor = static function (string $email) use ($advisors, $fallbackAdvisor): ?User {
      return $advisors->get($email) ?: $fallbackAdvisor;
    };

    $propiedades = [
      [
        'advisor_email'     => 'kelly@realestate.local',
        'referencia'       => 'APT-001',
        'titulo'           => 'Apartamento Moderno en Santo Domingo Este',
        'slug'             => 'apartamento-moderno-santo-domingo-este',
        'descripcion_corta' => 'Hermoso apartamento de 2 habitaciones con amenidades completas en una ubicación privilegiada.',
        'descripcion'      => '<p>Apartamento moderno con diseño contemporáneo en uno de los conjuntos residenciales más exclusivos de Santo Domingo Este. Cuenta con sala, comedor, cocina americana, 2 habitaciones con closets, 2 baños, balcón y parqueo cubierto.</p><p>El conjunto ofrece piscina, área de BBQ, seguridad 24 horas y planta eléctrica.</p>',
        'metadescription'  => 'Apartamento de 2 habitaciones en Santo Domingo Este con piscina, seguridad 24h y parqueo. Precio desde RD$4,500,000.',
        'precio'           => 4500000,
        'Moneda'           => 'RD$',
        'zona_id'          => $zona1,
        'provincia'        => 5, // Distrito Nacional
        'direccion'        => 'Av. España, Res. Las Palmas, Santo Domingo Este',
        'habitaciones'     => 2,
        'banos'            => 2,
        'parqueos'         => 1,
        'metraje'          => 95,
        'tipo'             => $tipoApto,
        'disponible_para'  => (string) $enVenta,
        'estado_id'        => $estadoNueva,
        'destacada'        => true,
        'activa'           => true,
        'aprobada'         => true,
        'vendida'          => false,
        'foto_portada'     => 'prop-apto-1.jpg', // Reemplazar con imagen real en assets/
        'piscina'          => true,
        'plantaelectrica'  => true,
        'seguridad24horas' => true,
        'parqueostechados' => true,
        'balcon'           => true,
      ],
      [
        'advisor_email'     => 'lavinia@realestate.local',
        'referencia'       => 'CASA-001',
        'titulo'           => 'Casa Familiar en Urbanización Exclusiva',
        'slug'             => 'casa-familiar-urbanizacion-exclusiva',
        'descripcion_corta' => 'Casa de 3 habitaciones con patio, gazebo y doble parqueo en urbanización cerrada.',
        'descripcion'      => '<p>Amplia casa unifamiliar en urbanización cerrada con calles internas y portón eléctrico. La propiedad cuenta con sala, comedor, cocina equipada, 3 habitaciones, 3 baños, patio trasero con gazebo y doble parqueo techado.</p><p>Excelente para familia. Cisterna y pozo propios.</p>',
        'metadescription'  => 'Casa de 3 habitaciones con patio, gazebo y parqueo doble en Santo Domingo Norte. Urbanización cerrada con seguridad.',
        'precio'           => 8900000,
        'Moneda'           => 'RD$',
        'zona_id'          => $zona2,
        'provincia'        => 31, // Santo Domingo
        'direccion'        => 'Urb. Los Jardines, Santo Domingo Norte',
        'habitaciones'     => 3,
        'banos'            => 3,
        'parqueos'         => 2,
        'metraje'          => 220,
        'metraje_construccion' => 180,
        'tipo'             => $tipoCasa,
        'disponible_para'  => (string) $enVenta,
        'estado_id'        => $estadoUsada,
        'destacada'        => true,
        'activa'           => true,
        'aprobada'         => true,
        'vendida'          => false,
        'foto_portada'     => 'prop-casa-1.jpg',
        'patio'            => true,
        'gazebo'           => true,
        'cisterna'         => true,
        'pozo'             => true,
        'portonelectrico'  => true,
        'parqueostechados' => true,
      ],
      [
        'advisor_email'     => 'kelly@realestate.local',
        'referencia'       => 'APT-002',
        'titulo'           => 'Apartamento Turístico con Vista al Mar en Bávaro',
        'slug'             => 'apartamento-turistico-vista-mar-bavaro',
        'descripcion_corta' => 'Apartamento de 1 habitación con vista al mar, piscina y acceso a playa en Bávaro.',
        'descripcion'      => '<p>Hermoso apartamento turístico ubicado a 200 metros de la playa en Bávaro. Ideal para inversión como Airbnb o para uso vacacional. Incluye acceso a piscina común, área de playa privada y seguridad 24 horas.</p><p>Precio incluye mobiliario y decoración completa.</p>',
        'metadescription'  => 'Apartamento turístico de 1 habitación con vista al mar en Bávaro. Ideal para inversión vacacional. Desde US$95,000.',
        'precio'           => 95000,
        'Moneda'           => 'US$',
        'zona_id'          => $zona3,
        'provincia'        => 13, // La Altagracia
        'direccion'        => 'Av. Las Américas, Bávaro, Punta Cana',
        'habitaciones'     => 1,
        'banos'            => 1,
        'parqueos'         => 1,
        'metraje'          => 65,
        'tipo'             => $tipoApto,
        'disponible_para'  => (string) $enVenta,
        'estado_id'        => $estadoNueva,
        'destacada'        => true,
        'activa'           => true,
        'aprobada'         => true,
        'vendida'          => false,
        'foto_portada'     => 'prop-apto-2.jpg',
        'piscina'          => true,
        'ascensor'         => true,
        'seguridad24horas' => true,
        'terraza'          => true,
      ],
      [
        'advisor_email'     => 'mario@realestate.local',
        'referencia'       => 'APT-003',
        'titulo'           => 'Apartamento en Alquiler cerca de Universidad',
        'slug'             => 'apartamento-alquiler-cerca-universidad',
        'descripcion_corta' => 'Moderno apartamento en alquiler de 2 habitaciones, amueblado, ideal para profesionales.',
        'descripcion'      => '<p>Cómodo apartamento amueblado de 2 habitaciones ubicado en zona estratégica cerca de universidades y centros comerciales. Cuenta con sala, cocina equipada, 1 baño, balcón y parqueo.</p><p>Incluye servicios de agua y seguridad. Internet de alta velocidad disponible.</p>',
        'metadescription'  => 'Apartamento de 2 habitaciones en alquiler amueblado en Santo Domingo Norte, ideal para profesionales y universitarios.',
        'precio'           => 18000,
        'Moneda'           => 'RD$',
        'zona_id'          => $zona2,
        'provincia'        => 31,
        'direccion'        => 'C/ Las Caobas, Santo Domingo Norte',
        'habitaciones'     => 2,
        'banos'            => 1,
        'parqueos'         => 1,
        'metraje'          => 75,
        'tipo'             => $tipoApto,
        'disponible_para'  => (string) $enAlquiler,
        'estado_id'        => $estadoUsada,
        'destacada'        => true,
        'activa'           => true,
        'aprobada'         => true,
        'vendida'          => false,
        'foto_portada'     => 'prop-apto-3.jpg',
        'balcon'           => true,
        'seguridad24horas' => true,
      ],
      [
        'advisor_email'     => 'lavinia@realestate.local',
        'referencia'       => 'CASA-002',
        'titulo'           => 'Villa de Lujo en Punta Cana con Piscina',
        'slug'             => 'villa-lujo-punta-cana-piscina',
        'descripcion_corta' => 'Espectacular villa de 4 habitaciones con piscina privada y jacuzzi en Punta Cana.',
        'descripcion'      => '<p>Villa de lujo en exclusivo complejo residencial en Punta Cana. La propiedad cuenta con 4 habitaciones en suite, piscina privada, jacuzzi, terraza, family room, cuarto de servicio y triple parqueo.</p><p>Rodeada de naturaleza, a pocos minutos del aeropuerto internacional y las mejores playas.</p>',
        'metadescription'  => 'Villa de lujo 4 habitaciones con piscina privada y jacuzzi en Punta Cana. Ideal para residencia o inversión turística.',
        'precio'           => 350000,
        'Moneda'           => 'US$',
        'zona_id'          => $zona4,
        'provincia'        => 13,
        'direccion'        => 'Res. Cap Cana, Punta Cana',
        'habitaciones'     => 4,
        'banos'            => 4,
        'parqueos'         => 3,
        'metraje'          => 480,
        'metraje_construccion' => 380,
        'tipo'             => $tipoCasa,
        'disponible_para'  => (string) $enVenta,
        'estado_id'        => $estadoNueva,
        'destacada'        => true,
        'activa'           => true,
        'aprobada'         => true,
        'vendida'          => false,
        'foto_portada'     => 'prop-villa-1.jpg',
        'piscina'          => true,
        'jacuzzi'          => true,
        'terraza'          => true,
        'familyroom'       => true,
        'cuartodeservicio' => true,
        'seguridad24horas' => true,
        'controldeacceso'  => true,
        'parqueostechados' => true,
        'walkincloset'     => true,
      ],
      [
        'advisor_email'     => 'kelly@realestate.local',
        'referencia'       => 'APT-004',
        'titulo'           => 'Apartamento en Planos con Financiamiento Bancario',
        'slug'             => 'apartamento-en-planos-financiamiento-bancario',
        'descripcion_corta' => 'Invierte desde planos en este moderno proyecto con entrega en 18 meses y financiamiento disponible.',
        'descripcion'      => '<p>Excelente oportunidad de inversión en proyecto residencial en planos ubicado en Santo Domingo Este. Apartamentos de 2 habitaciones con acabados de primera, piscina, área de BBQ, gimnasio y seguridad 24 horas.</p><p>Financiamiento bancario aprobado. Cuota inicial desde el 20%. Entrega estimada en 18 meses.</p>',
        'metadescription'  => 'Apartamento en planos en Santo Domingo Este con financiamiento bancario. 2 habitaciones, desde RD$5,200,000.',
        'precio'           => 5200000,
        'Moneda'           => 'RD$',
        'zona_id'          => $zona1,
        'provincia'        => 31,
        'direccion'        => 'Av. San Vicente de Paul, Santo Domingo Este',
        'habitaciones'     => 2,
        'banos'            => 2,
        'parqueos'         => 1,
        'metraje'          => 100,
        'tipo'             => $tipoApto,
        'disponible_para'  => (string) $enVenta,
        'estado_id'        => $estadoEnPlano,
        'destacada'        => true,
        'activa'           => true,
        'aprobada'         => true,
        'vendida'          => false,
        'foto_portada'     => 'prop-apto-4.jpg',
        'piscina'          => true,
        'gimnasio'         => true,
        'ascensor'         => true,
        'seguridad24horas' => true,
        'lobby'            => true,
        'plantaelectrica'  => true,
      ],
      [
        'advisor_email'     => 'mario@realestate.local',
        'referencia'       => 'OFI-001',
        'titulo'           => 'Oficina corporativa en Piantini',
        'slug'             => 'oficina-corporativa-en-piantini',
        'descripcion_corta' => 'Oficina equipada con recepcion, sala de reuniones y parqueos en zona premium.',
        'descripcion'      => '<p>Amplia oficina en torre corporativa de Piantini, ideal para equipos comerciales, consultoria o servicios profesionales.</p><p>Incluye recepcion, area abierta de trabajo, sala de reuniones, kitchenette y 2 parqueos asignados.</p>',
        'metadescription'  => 'Oficina en venta en Piantini con excelente ubicacion y espacios funcionales para empresas.',
        'precio'           => 12500000,
        'Moneda'           => 'RD$',
        'zona_id'          => $zonaIds->get('Piantini', $zona1),
        'provincia'        => 5,
        'direccion'        => 'Av. Abraham Lincoln, Piantini, Distrito Nacional',
        'habitaciones'     => 0,
        'banos'            => 2,
        'parqueos'         => 2,
        'metraje'          => 140,
        'tipo'             => $tipoOficina,
        'disponible_para'  => (string) $enVenta,
        'estado_id'        => $estadoUsada,
        'destacada'        => true,
        'activa'           => true,
        'aprobada'         => true,
        'vendida'          => false,
        'foto_portada'     => 'prop-oficina-1.jpg',
        'ascensor'         => true,
        'seguridad24horas' => true,
        'plantaelectrica'  => true,
        'controldeacceso'  => true,
      ],
    ];

    foreach ($propiedades as $data) {
      $advisor = $advisorFor((string) ($data['advisor_email'] ?? ''));

      if ($advisor) {
        $data['asignada_a'] = $advisor->email;
        $data['asignada_a_id'] = $advisor->id;
        $data['captada_por'] = $advisor->id;
        $data['foto_vendedor'] = $advisor->foto;
      }

      unset($data['advisor_email']);

      Propiedad::updateOrCreate(
        ['referencia' => $data['referencia']],
        $data
      );
    }
  }
}
