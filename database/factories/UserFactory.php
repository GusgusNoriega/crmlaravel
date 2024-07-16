<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\Image;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'telefono' => $this->faker->phoneNumber,
            'cargo' => fake()->name(),
            'role_id' => Role::inRandomOrder()->first()->id,
            'image_id' => $this->getImageId(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    private function getImageId()
    {
        if (Image::count() > 0) {
            // Si hay imágenes disponibles, asigna una al azar
            return Image::inRandomOrder()->first()->id;
        }
        
        // Opcional: Crear una nueva imagen si no hay ninguna disponible
        // return Image::factory()->create()->id;
        
        return null; // Devuelve null si no quieres asignar una imagen
    }

    
}
