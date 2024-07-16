<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categoria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoriaPadre = Categoria::inRandomOrder()->first();

        return [
            'name' => $this->faker->word,
            'categoria_padre_id' => $categoriaPadre ? $categoriaPadre->id : null,
        ];
    }
}
