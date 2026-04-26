<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
  public function run(): void
  {
    $posts = [
      [
        'titulo'          => 'Cómo elegir el mejor barrio para vivir en Santo Domingo',
        'autor'           => 'Equipo Inmobiliario',
        'palabraclave'    => 'barrios',
        'contenido'       => '<p>Elegir el barrio adecuado es una de las decisiones más importantes al comprar o alquilar una propiedad. En Santo Domingo encontrarás opciones para todos los estilos de vida y presupuestos.</p><p>Analiza la accesibilidad, la seguridad, la cercanía a escuelas y centros comerciales, y el potencial de valorización a futuro. Nuestros asesores pueden guiarte en este proceso.</p>',
        'foto'            => 'post-1.jpg',
        'metadescription' => 'Guía para elegir el barrio ideal en Santo Domingo: factores clave de seguridad, accesibilidad y valorización.',
        'activo'          => true,
        'slug'            => 'como-elegir-el-mejor-barrio-para-vivir-en-santo-domingo',
      ],
      [
        'titulo'          => '5 claves para negociar el precio de una propiedad',
        'autor'           => 'Equipo Inmobiliario',
        'palabraclave'    => 'negociacion',
        'contenido'       => '<p>Negociar el precio de una propiedad requiere información y estrategia. Conoce el valor del mercado en la zona, solicita un historial de precio y ten claro tu presupuesto máximo.</p><p>Nunca hagas una oferta sin haber visitado la propiedad personalmente. Un buen asesor inmobiliario puede marcar la diferencia en la negociación final.</p>',
        'foto'            => 'post-2.jpg',
        'metadescription' => 'Descubre 5 estrategias prácticas para negociar el precio de una propiedad y conseguir el mejor trato.',
        'activo'          => true,
        'slug'            => '5-claves-para-negociar-el-precio-de-una-propiedad',
      ],
      [
        'titulo'          => 'Tendencias del mercado inmobiliario dominicano en 2025',
        'autor'           => 'Equipo Inmobiliario',
        'palabraclave'    => 'inmobiliario',
        'contenido'       => '<p>El mercado inmobiliario en República Dominicana sigue en crecimiento. La demanda de apartamentos en zonas turísticas y urbanas se mantiene alta, impulsada por la inversión extranjera y el turismo residencial.</p><p>Invertir en propiedades en zonas emergentes puede generar retornos importantes a mediano plazo. Consulta con un especialista para identificar las mejores oportunidades.</p>',
        'foto'            => 'post-3.jpg',
        'metadescription' => 'Análisis de las principales tendencias del mercado inmobiliario dominicano en 2025 y oportunidades de inversión.',
        'activo'          => true,
        'slug'            => 'tendencias-del-mercado-inmobiliario-dominicano-en-2025',
      ],
    ];

    foreach ($posts as $post) {
      Post::updateOrCreate(
        ['slug' => $post['slug']],
        $post
      );
    }
  }
}
