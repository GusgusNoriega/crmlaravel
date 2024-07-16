<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Image;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'tipo' => $this->faker->randomElement(['particular', 'empleado']), 
            'email' => $this->faker->unique()->safeEmail,
            'ruc' => $this->faker->unique()->numerify('##########'), // Ejemplo de RUC con 10 dígitos
            'telefono' => $this->faker->phoneNumber,
            'direccion' => $this->faker->address,
            'user_id' => User::inRandomOrder()->first()->id, // Obtener un ID de usuario existente
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Cliente $cliente) {

                $imagen = Image::inRandomOrder()->first();
                if ($imagen) {
                    $cliente->imagen_destacada = $imagen->id;
                    $cliente->save(); // Guardar el cambio
                }
        });
    }
 
}
