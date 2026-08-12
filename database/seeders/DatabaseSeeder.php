<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Categorie;
use App\Models\Produit;
use App\Models\Vente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer un Admin
        User::create([
            'name' => 'Admin CROWN',
            'email' => 'admin@crown.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Créer un Client
        $userClient = User::create([
            'name' => 'Marie Rakoto',
            'email' => 'marie@crown.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);

        // On sauvegarde le client créé dans une variable $client
        $client = Client::create([
            'user_id' => $userClient->id,
            'nom' => 'Rakoto',
            'prenom' => 'Marie',
            'contact' => '034 00 000 00',
            'adresse' => 'Antananarivo, Madagascar',
        ]);

        // 3. Créer des Catégories
        $shampoing = Categorie::create(['nom' => 'Shampooings', 'description' => 'Soins lavants naturels']);
        $masque = Categorie::create(['nom' => 'Masques', 'description' => 'Soins profonds']);
        $huile = Categorie::create(['nom' => 'Huiles', 'description' => 'Sérums et huiles précieuses']);

        // 4. Créer 12 Produits
        $produitsData = [
            ['nom' => 'Shampooing Nutri Boucles', 'desc' => 'Sans sulfates, enrichi en huile de coco.', 'prix' => 15000, 'stock' => 50, 'cat' => $shampoing->id],
            ['nom' => 'Shampooing Force & Volume', 'desc' => 'Pour cheveux fins, à la protéine de riz.', 'prix' => 16000, 'stock' => 40, 'cat' => $shampoing->id],
            ['nom' => 'Masque Réparateur Intense', 'desc' => 'Au beurre de karité pour cheveux secs.', 'prix' => 22000, 'stock' => 30, 'cat' => $masque->id],
            ['nom' => 'Masque Hydratant Monoï', 'desc' => 'Fleur de tiaré et huile de monoï.', 'prix' => 20000, 'stock' => 25, 'cat' => $masque->id],
            ['nom' => 'Huile Précieuse Éclat', 'desc' => 'Mélange de 5 huiles pour la brillance.', 'prix' => 18000, 'stock' => 20, 'cat' => $huile->id],
            ['nom' => 'Sérum Anti-Frisottis', 'desc' => 'Lisse et protège de l\'humidité.', 'prix' => 19000, 'stock' => 15, 'cat' => $huile->id],
            ['nom' => 'Shampooing Doux Enfants', 'desc' => 'Formule sans larmes, très douce.', 'prix' => 12000, 'stock' => 60, 'cat' => $shampoing->id],
            ['nom' => 'Masque Curl Definition', 'desc' => 'Pour définir les boucles et spirales.', 'prix' => 21000, 'stock' => 35, 'cat' => $masque->id],
            ['nom' => 'Huile de Ricin Noire', 'desc' => 'Favorise la pousse et fortifie.', 'prix' => 17000, 'stock' => 45, 'cat' => $huile->id],
            ['nom' => 'Shampooing Clarifiant', 'desc' => 'Nettoie en profondeur une fois par mois.', 'prix' => 14000, 'stock' => 20, 'cat' => $shampoing->id],
            ['nom' => 'Masque Protéiné Kératine', 'desc' => 'Répare les cheveux abîmés.', 'prix' => 25000, 'stock' => 10, 'cat' => $masque->id],
            ['nom' => 'Huile d\'Argan Bio', 'desc' => 'L\'or liquide du Maroc pour vos pointes.', 'prix' => 23000, 'stock' => 12, 'cat' => $huile->id],
        ];

        foreach ($produitsData as $data) {
            Produit::create([
                'categorie_id' => $data['cat'],
                'nom' => $data['nom'],
                'description' => $data['desc'],
                'prix' => $data['prix'],
                'quantite_stock' => $data['stock'],
            ]);
        }

        // 5. Créer une Vente de test
        $premierProduit = Produit::first();
        
        // On utilise $client->id ici (la variable qu'on a créée plus haut)
        $vente = Vente::create([
            'code_vente' => 'V-' . now()->format('d-m-Y') . '-001',
            'client_id' => $client->id, 
            'montant' => $premierProduit->prix * 2,
            'date_vente' => now(),
            'statut' => 'payé',
        ]);

        $vente->produits()->attach($premierProduit->id, [
            'quantite' => 2,
            'prix_unitaire' => $premierProduit->prix,
            'sous_total' => $premierProduit->prix * 2,
        ]);
        
        $premierProduit->decrement('quantite_stock', 2);
    }
}