<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{
    // Ajouter un produit au panier
    public function ajouter(Request $request, Produit $produit)
    {
        $client = Auth::user()->client;

        $panierItem = Panier::where('client_id', $client->id)
                            ->where('produit_id', $produit->id)
                            ->first();

        if ($panierItem) {
            $panierItem->increment('quantite');
        } else {
            Panier::create([
                'client_id' => $client->id,
                'produit_id' => $produit->id,
                'quantite' => 1,
            ]);
        }

        return redirect()->back()->with('success', $produit->nom . ' ajouté au panier ! ');
    }

    // Voir son panier
    public function voirPanier()
    {
        $client = Auth::user()->client;
        $panier = Panier::where('client_id', $client->id)->with('produit')->get();
        
        $total = $panier->sum(function($item) {
            return $item->produit->prix * $item->quantite;
        });

        return view('panier.index', compact('panier', 'total'));
    }

    // Supprimer un article
    public function supprimer($id)
    {
        Panier::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Article retiré du panier.');
    }
}