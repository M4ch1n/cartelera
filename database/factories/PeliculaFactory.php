<?php

namespace Database\Factories;

use App\Models\Pelicula;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeliculaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pelicula::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->sentence($nbWords = 3, $variableNbWords = true),
            'estado' => $this->faker->boolean($chanceOfGettingTrue = 50),
            'imagen' => $this->faker->image('storage/app/public/',640,480, null, false)
        ];
    }

    /**
     * Se elimina el nombre del arreglo
     * @return [type] [description]
     */
    public function sinNombre()
    {
        return $this->state(function (array $attributes) {
            return [
                'nombre' => '',
            ];
        });
    }
}
