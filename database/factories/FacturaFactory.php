<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Factura>
 */
class FacturaFactory extends Factory
{
    /**
     * Define the model's default state.s
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha_emision' => $this->faker->date('Y-m-d'),
            'fecha_de_pago' => $this->faker->date('Y-m-d'),
            'fecha_de_vencimiento' => $this->faker->date('Y-m-d'),
            'nro_factura' => $this->faker->numerify('###########'),
            'nro_guia' => $this->faker->numerify('###########'),
            'total' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000),
        ];
    }
}
