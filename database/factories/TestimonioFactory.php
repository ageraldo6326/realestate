<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'testimonio' => $this->faker->text($maxNbChars = 220),
            'cliente' => $this->faker->text($maxNbChars = 20)

            //
        ];
    }
}
