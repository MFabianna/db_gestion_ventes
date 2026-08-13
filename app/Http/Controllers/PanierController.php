<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Produit;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{
    // Afficher le panier
    public function index()
    {
        $user = Auth::user();
        
        // Sécurité : Si l'utilisateur n'a pas de fiche client, on la crée à la volée
        $client = $user->client;
        if (!$client) {
            $client = Client::create([
                'user_id' => $user->id,
                'nom' => $user->name,
                'prenom' => 'Client',
                'contact' => '000000000',
                'adresse' => 'Adresse non renseignée'
            ]);
        }

        $paniers = Panier::with('produit')->where('client_id', $client->id)->get();

        $total = $paniers->sum(function($item) {
            return $item->produit->prix * $item->quantite;
        });

        return view('panier.index', compact('paniers', 'total'));
    }

    // Ajouter un produit au panier
    public function ajouter(Produit $produit)
    {
        $user = Auth::user();
        
        $client = $user->client;
        if (!$client) {
            $client = Client::create([
                'user_id' => $user->id,
                'nom' => $user->name,
                'prenom' => 'Client',
                'contact' => '000000000',
                'adresse' => 'Adresse non renseignée'
            ]);
        }

        // Vérifier si le produit est déjà dans le panier
        $panier = Panier::where('client_id', $client->id)
                        ->where('produit_id', $produit->id)
                        ->first();

        if ($panier) {
            // Si déjà dans le panier, on augmente la quantité
            $panier->quantite += 1;
            $panier->save();
        } else {
            // Sinon, on l'ajoute
            Panier::create([
                'client_id' => $client->id,
                'produit_id' => $produit->id,
                'quantite' => 1,
            ]);
        }

        return redirect()->route('panier.voir')->with('success', 'Produit ajouté au panier ! 🛒');
    }

    // Supprimer un produit du panier
    public function supprimer(Panier $item)
    {
        $item->delete();
        return redirect()->route('panier.voir')->with('success', 'Produit retiré du panier ! 🗑️');
    }
}