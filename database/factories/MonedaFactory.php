<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Moneda>
 */
class MonedaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'code' => $this->faker->unique()->currencyCode,
            'symbol' => $this->faker->randomElement(['$', '€', '£', '¥']), // Puedes agregar más símbolos si es necesario
            'tipo_cambio' => $this->faker->randomFloat(2, 0, 100), // Tipo de cambio con 2 decimales
        ];
    }
}
