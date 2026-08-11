<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProduitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'categorie_id' => Categorie::factory(),
            'nom' => fake()->randomElement(['Shampooing', 'Masque', 'Huile', 'Sérum']) . ' ' . fake()->words(3, true),
            'description' => fake()->paragraph(2),
            'prix' => fake()->numberBetween(5000, 30000),
            'quantite_stock' => fake()->numberBetween(0, 100),
            'image' => 'produit_' . fake()->unique()->numberBetween(1, 50) . '.jpg',
        ];
    }
}