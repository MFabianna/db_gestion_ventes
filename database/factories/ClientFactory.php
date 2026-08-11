<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => 'client']),
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'contact' => '034 ' . fake()->numberBetween(10, 99) . ' ' . fake()->numberBetween(100, 999) . ' ' . fake()->numberBetween(10, 99),
            'adresse' => fake()->address(),
        ];
    }
}