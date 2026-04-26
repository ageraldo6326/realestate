<?php

namespace Database\Seeders;

use App\Models\Clientes;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
  public function run(): void
  {
    // Usar el usuario admin como captado_por y asignado_a por defecto
    $adminId = User::where('email', 'admin@realestate.local')->value('id') ?? 1;

    $contactos = [
      [
        'nombre'        => 'Ana Martínez',
        'tipo_contacto' => 'Comprador',
        'tipo_contacto2' => 'Potencial',
        'telefono'      => '8091110001',
        'email'         => 'ana.martinez@email.com',
        'comentario'    => 'Busca apartamento de 2 habitaciones en Santo Domingo Este. Presupuesto hasta RD$5,000,000.',
        'activo'        => true,
        'captado_por'   => $adminId,
        'asignado_a'    => $adminId,
        'medio'         => 'Facebook',
        'precio_mini'   => 3500000,
        'precio_max'    => 5000000,
      ],
      [
        'nombre'        => 'Roberto Sánchez',
        'tipo_contacto' => 'Comprador',
        'tipo_contacto2' => 'Calificado',
        'telefono'      => '8091110002',
        'email'         => 'roberto.sanchez@email.com',
        'comentario'    => 'Inversionista interesado en locales comerciales y apartamentos turísticos en Bávaro.',
        'activo'        => true,
        'captado_por'   => $adminId,
        'asignado_a'    => $adminId,
        'medio'         => 'Instagram',
        'precio_mini'   => 80000,
        'precio_max'    => 300000,
      ],
      [
        'nombre'        => 'Carmen López',
        'tipo_contacto' => 'Arrendatario',
        'tipo_contacto2' => 'Potencial',
        'telefono'      => '8091110003',
        'email'         => 'carmen.lopez@email.com',
        'comentario'    => 'Busca apartamento en alquiler en Piantini o Naco. Presupuesto mensual hasta RD$25,000.',
        'activo'        => true,
        'captado_por'   => $adminId,
        'asignado_a'    => $adminId,
        'medio'         => 'Referido',
        'precio_mini'   => 15000,
        'precio_max'    => 25000,
      ],
      [
        'nombre'        => 'José Hernández',
        'tipo_contacto' => 'Vendedor',
        'tipo_contacto2' => 'Activo',
        'telefono'      => '8091110004',
        'email'         => 'jose.hernandez@email.com',
        'comentario'    => 'Propietario con casa en venta en Bella Vista. Precio solicitado RD$12,000,000.',
        'activo'        => true,
        'captado_por'   => $adminId,
        'asignado_a'    => $adminId,
        'medio'         => 'WhatsApp',
        'precio_mini'   => 10000000,
        'precio_max'    => 12000000,
      ],
      [
        'nombre'        => 'Patricia Reyes',
        'tipo_contacto' => 'Comprador',
        'tipo_contacto2' => 'Potencial',
        'telefono'      => '8091110005',
        'email'         => 'patricia.reyes@email.com',
        'comentario'    => 'Primera vez comprando. Interesada en proyecto en planos en Santo Domingo Norte con financiamiento bancario.',
        'activo'        => true,
        'captado_por'   => $adminId,
        'asignado_a'    => $adminId,
        'medio'         => 'Portal web',
        'precio_mini'   => 4000000,
        'precio_max'    => 6000000,
      ],
      [
        'nombre'        => 'Marcos Díaz',
        'tipo_contacto' => 'Arrendador',
        'tipo_contacto2' => 'Activo',
        'telefono'      => '8091110006',
        'email'         => 'marcos.diaz@email.com',
        'comentario'    => 'Propietario con 3 apartamentos en Los Mina disponibles para alquiler. Precio RD$18,000 c/u.',
        'activo'        => true,
        'captado_por'   => $adminId,
        'asignado_a'    => $adminId,
        'medio'         => 'Referido',
        'precio_mini'   => 16000,
        'precio_max'    => 20000,
      ],
      [
        'nombre'        => 'Lucía Fernández',
        'tipo_contacto' => 'Comprador',
        'tipo_contacto2' => 'Calificado',
        'telefono'      => '8091110007',
        'email'         => 'lucia.fernandez@email.com',
        'comentario'    => 'Busca villa o casa en Cap Cana o Punta Cana para residencia vacacional. Inversión en dólares.',
        'activo'        => true,
        'captado_por'   => $adminId,
        'asignado_a'    => $adminId,
        'medio'         => 'Google',
        'precio_mini'   => 200000,
        'precio_max'    => 500000,
      ],
      [
        'nombre'        => 'Diego Morales',
        'tipo_contacto' => 'Comprador',
        'tipo_contacto2' => 'Potencial',
        'telefono'      => '8091110008',
        'email'         => 'diego.morales@email.com',
        'comentario'    => 'Empresario interesado en locales comerciales en Herrera o Los Alcarrizos para expandir negocio.',
        'activo'        => true,
        'captado_por'   => $adminId,
        'asignado_a'    => $adminId,
        'medio'         => 'Facebook',
        'precio_mini'   => 5000000,
        'precio_max'    => 10000000,
      ],
      [
        'nombre'        => 'Valeria Castro',
        'tipo_contacto' => 'Arrendatario',
        'tipo_contacto2' => 'Calificado',
        'telefono'      => '8091110009',
        'email'         => 'valeria.castro@email.com',
        'comentario'    => 'Estudiante universitaria busca estudio o apartamento pequeño cerca de universidades en el DN.',
        'activo'        => true,
        'captado_por'   => $adminId,
        'asignado_a'    => $adminId,
        'medio'         => 'Instagram',
        'precio_mini'   => 8000,
        'precio_max'    => 14000,
      ],
      [
        'nombre'        => 'Fernando Guzmán',
        'tipo_contacto' => 'Comprador',
        'tipo_contacto2' => 'Calificado',
        'telefono'      => '8091110010',
        'email'         => 'fernando.guzman@email.com',
        'comentario'    => 'Dominicano en el exterior buscando invertir en propiedad para rentarla. Preferencia por zonas turísticas.',
        'activo'        => true,
        'captado_por'   => $adminId,
        'asignado_a'    => $adminId,
        'medio'         => 'WhatsApp',
        'precio_mini'   => 100000,
        'precio_max'    => 250000,
      ],
    ];

    foreach ($contactos as $contacto) {
      Clientes::firstOrCreate(
        ['email' => $contacto['email']],
        $contacto
      );
    }
  }
}
