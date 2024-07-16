<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Image;
use App\Models\Marca;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Marca>
 */
class MarcaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Marca $marca) {
            // Asigna una imagen destacada si hay imágenes disponibles
            $imagen = Image::inRandomOrder()->first();
            if ($imagen) {
                $marca->imagen_destacada = $imagen->id;
                $marca->save();
            }
        });
    }
}
