<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategorieFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => fake()->unique()->randomElement(['Shampooings', 'Masques', 'Huiles', 'Sérums', 'Accessoires']),
            'description' => fake()->sentence(10),
        ];
    }
}