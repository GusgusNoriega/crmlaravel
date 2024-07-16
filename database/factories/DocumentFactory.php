<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
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
            'tipo' => $this->faker->randomElement(['pdf', 'jpg', 'jpeg', 'wep']),// Genera un nombre ficticio
            'ruta' => 'document/' . $this->faker->unique()->word . '.jpg', // Genera una ruta ficticia
        ];
    }
}
