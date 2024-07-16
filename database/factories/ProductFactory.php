<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Moneda;
use App\Models\Categoria;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'sku' => $this->faker->unique()->bothify('SKU-####??'), // SKU con números y letras
            'description' => implode("\n", $this->faker->paragraphs()),
            'cont_envio' => implode("\n", $this->faker->paragraphs()),
            'datos_tecnicos' => implode("\n", $this->faker->paragraphs()), 
            'modelo' => $this->faker->bothify('Modelo-###??'), // Modelo con números y letras
            'moneda' => Moneda::inRandomOrder()->first()->id, // Código de moneda
            'precio' => $this->faker->randomFloat(2, 0, 1000), // Número flotante con 2 decimales entre 0 y 1000
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            // Asumiendo que quieres asociar cada producto con 1 a 3 categorías aleatorias
            $categorias = Categoria::inRandomOrder()->take(rand(1, 3))->get();
            $product->categorias()->attach($categorias);
            // Asignar una imagen destacada existente, o dejar en null si no hay imágenes
                $imagen = Image::inRandomOrder()->first();
                if ($imagen) {
                    $product->imagen_destacada = $imagen->id;
                    $product->save(); // Guardar el cambio
                }
        });
    }
}
