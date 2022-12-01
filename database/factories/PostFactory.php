<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->text($maxNbChars = 60),
            'autor' => $this->faker->text($maxNbChars = 8),
            'palabraclave'  => $this->faker->text($maxNbChars = 8),
            'contenido'  => $this->faker->text($maxNbChars = 220),
             'foto' => '/img/blog/' . rand(1,3) . '.jpg'
            //
        ];
    }
}
