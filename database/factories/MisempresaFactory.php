<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Misempresa>
 */
class MisempresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            // Obtiene dos IDs de imagen aleatorios
            $imagenLogoId = Image::inRandomOrder()->first();
            $imagenSelloId = Image::inRandomOrder()->first();
    
            return [
                'name' => $this->faker->company,
                'slug' => $this->faker->slug,
                'ruc' => $this->faker->numerify('###########'),
                'alias' => $this->faker->word,
                'telefono' => $this->faker->phoneNumber,
                'imagen_logo' => $imagenLogoId,
                'imagen_sello' => $imagenSelloId,
                'cuenta_soles' => $this->faker->numerify('##########'), // 10 dígitos
                'cuenta_dolares' => $this->faker->numerify('##########'),
                'cuenta_nacion' => $this->faker->numerify('##########'),
                // otros campos...
            ];
        
    }
}