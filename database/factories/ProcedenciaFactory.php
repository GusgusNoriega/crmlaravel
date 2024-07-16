<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Image;
use App\Models\Procedencia;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Procedencia>
 */
class ProcedenciaFactory extends Factory
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
        return $this->afterCreating(function (Procedencia $procedencia) {
            // Asigna una imagen destacada si hay imágenes disponibles
            $imagen = Image::inRandomOrder()->first();
            if ($imagen) {
                $procedencia->imagen_destacada = $imagen->id;
                $procedencia->save();
            }
        });
    }
}
