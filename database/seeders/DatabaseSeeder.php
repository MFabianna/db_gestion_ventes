<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crée les catégories de base
        $shampooings = Categorie::firstOrCreate(['nom' => 'Shampooings']);
        $masques = Categorie::firstOrCreate(['nom' => 'Masques']);
        $huiles = Categorie::firstOrCreate(['nom' => 'Huiles']);

        // 2. Crée le compte ADMIN
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@crown.com'],
            [
                'name' => 'Admin CROWN',
                'password' => Hash::make('147258crown'),
                'role' => 'admin',
            ]
        );

        Client::updateOrCreate(
            ['user_id' => $adminUser->id],
            [
                'nom' => 'Admin',
                'prenom' => 'CROWN',
                'contact' => '032 96 328 56',
                'adresse' => 'Siège CROWN',
            ]
        );

        // 3. Créer quelques produits de test (si la table est vide)
        if (Produit::count() === 0) {
            Produit::create([
                'nom' => 'Shampooing Hydratant Coco',
                'description' => 'Formule nourrissante à l\'huile de coco pour cheveux secs.',
                'prix' => 16000,
                'quantite_stock' => 25,
                'categorie_id' => $shampooings->id,
            ]);

            Produit::create([
                'nom' => 'Masque Réparateur Karité',
                'description' => 'Soin profond au beurre de karité pour des cheveux forts.',
                'prix' => 20000,
                'quantite_stock' => 15,
                'categorie_id' => $masques->id,
            ]);
        }
    }
}