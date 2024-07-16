<?php

namespace Database\Factories;

use App\Models\Misempresa;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Moneda;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cotizacion>
 */
class CotizacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nro_cotizacion' => $this->faker->unique()->numberBetween(1000, 9999),
            'fecha_cotizacion' => $this->faker->date(),
            'fecha_vencimiento' => $this->faker->date(),
            'entrega' => $this->faker->word,
            'lugar_entrega' => $this->faker->address,
            'garantia' => $this->faker->sentence,
            'forma_de_pago' => $this->faker->word,
            'tipo_de_cambio' => $this->faker->randomFloat(2, 1, 10),
            'adicionales' => $this->faker->sentence,
            'total' => $this->faker->randomFloat(2, 100, 10000),

            // Claves foráneas - Asegúrate de que estas tablas ya tengan datos
            'misempresa_id' => Misempresa::inRandomOrder()->first()->id ?? Misempresa::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'cliente_id' => Cliente::inRandomOrder()->first()->id ?? Cliente::factory(),
            'moneda_id' => Moneda::inRandomOrder()->first()->id ?? Moneda::factory(),
        ];
    }
}
