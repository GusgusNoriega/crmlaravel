<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'tipo' => $this->faker->randomElement(['png', 'jpg', 'jpeg', 'wep']),// Genera un nombre ficticio
            'ruta' => 'images/' . $this->faker->unique()->word . '.jpg', // Genera una ruta ficticia
            'alt' => $this->faker->sentence, // Genera un texto alternativo ficticio
            'ruta_anterior' => 'images/' . $this->faker->unique()->word . '.jpg', // Genera una ruta anterior ficticia
        ];
    }
}