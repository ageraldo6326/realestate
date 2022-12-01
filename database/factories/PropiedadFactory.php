<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Propiedad;

class PropiedadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $foto_array = array('http://127.0.0.1/img/destacadas/casa1.png', 
        'http://127.0.0.1/img/destacadas/casa2.png', 
        'http://127.0.0.1/img/destacadas/casa3.png', 
        'http://127.0.0.1/img/destacadas/casa4.png');

        $disponible_para = array('En Venta','En Compra','En Alquiler');

        sleep(1);

        $foto = $foto_array[rand(1,3)];
        return [
            'foto_portada' => $foto,
            'titulo' => $this->faker->text($maxNbChars = 60),
            'precio'  => $this->faker->numberBetween($min = 9000000, $max = 18000000),
            'descripcion_corta' => $this->faker->text($maxNbChars = 150),
            'descripcion' => $this->faker->text($maxNbChars = 300),
            'banos' => rand(1,3),
            'habitaciones' => rand(2,6),
            'parqueos' => rand(1,3),
            'metraje' => rand('80','400'),
            'direccion' => $this->faker->text($maxNbChars = 35),
            'disponible_para' => $disponible_para[rand(0,2)],
            'jacuzzi' => rand(0,1),
            'lobby' => rand(0,1),
            'plantaelectrica' => rand(0,1),
            'balcon' => rand(0,1),
            'gascomun' => rand(0,1),
            'piscina' => rand(0,1),
            'gazebo' => rand(0,1),
            'walkincloset' => rand(0,1),
            'maderapreciosa' => rand(0,1),
            'camaravigilancia' => rand(0,1),
            'gimnasio' => rand(0,1),
            'terraza' => rand(0,1),
            'tipo' => rand(1,3),
            'zona_id' => rand(1,4)

        ];
    }
}
