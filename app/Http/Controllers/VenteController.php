<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VenteController extends Controller
{
    // Fonction pour générer le code unique
    private function genererCodeVente()
    {
        $date = now();
        $jour = $date->format('d');
        $mois = $date->format('m');
        $annee = $date->format('Y');
        
        $nombreVentesAujourdhui = Vente::whereDate('created_at', $date)->count();
        $numero = str_pad($nombreVentesAujourdhui + 1, 3, '0', STR_PAD_LEFT);
        
        return "V-{$jour}-{$mois}-{$annee}-{$numero}";
    }

    // Valider le panier et créer la vente
    public function validerCommande(Request $request)
    {
        $client = Auth::user()->client;
        
        $panier = Panier::where('client_id', $client->id)->with('produit')->get();
        if ($panier->isEmpty()) {
            return redirect()->back()->with('error', 'Votre panier est vide !');
        }

        $montantTotal = 0;
        $codeVente = $this->genererCodeVente();

        $vente = Vente::create([
            'code_vente' => $codeVente,
            'client_id' => $client->id,
            'montant' => 0,
            'date_vente' => now(),
            'statut' => 'payé',
        ]);

        foreach ($panier as $item) {
            $produit = $item->produit;
            $quantite = $item->quantite;
            $prixUnitaire = $produit->prix;
            $sousTotal = $prixUnitaire * $quantite;

            $vente->produits()->attach($produit->id, [
                'quantite' => $quantite,
                'prix_unitaire' => $prixUnitaire,
                'sous_total' => $sousTotal,
            ]);

            $produit->decrement('quantite_stock', $quantite);
            $montantTotal += $sousTotal;
        }

        $vente->update(['montant' => $montantTotal]);
        Panier::where('client_id', $client->id)->delete();

        return redirect()->route('recu.show', $vente->id)->with('success', 'Commande validée avec succès !');
    }

    // Afficher le reçu
    public function showRecu($id)
    {
        $vente = Vente::with(['client.user', 'produits'])->findOrFail($id);
        return view('ventes.recu', compact('vente'));
    }
}