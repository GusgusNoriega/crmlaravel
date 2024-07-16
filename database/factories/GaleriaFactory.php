<?php

namespace Database\Factories;
use App\Models\Galeria;
use App\Models\Image;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Galeria>
 */
class GaleriaFactory extends Factory
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
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Galeria $galeria) {
            // Suponiendo que quieres adjuntar un número aleatorio de imágenes y productos existentes
            $images = Image::inRandomOrder()->limit(rand(1, 5))->get();
            $galeria->images()->attach($images);

            $products = Product::inRandomOrder()->limit(rand(1, 3))->get();
            foreach ($products as $product) {
                $product->galeria_id = $galeria->id;
                $product->save();
            }
        });
    }
}
