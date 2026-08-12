<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Affiche la page d'accueil avec la liste des produits et les filtres
     */
    public function index(Request $request)
    {
        // une requête de base qui inclut la catégorie
        $query = Produit::with('categorie');

        // 1. Filtre de recherche par nom
        if ($request->has('search') && $request->search != '') {
            $query->where('nom', 'LIKE', '%' . $request->search . '%');
        }

        // 2. Filtre par catégorie
        if ($request->has('categorie') && $request->categorie != '') {
            $query->where('categorie_id', $request->categorie);
        }

        // 3. Filtre par prix minimum
        if ($request->has('prix_min') && $request->prix_min != '') {
            $query->where('prix', '>=', $request->prix_min);
        }

        // 4. Filtre par prix maximum
        if ($request->has('prix_max') && $request->prix_max != '') {
            $query->where('prix', '<=', $request->prix_max);
        }

        // On récupère les produits filtrés, du plus récent au plus ancien
        $produits = $query->latest()->get();
        
        // On récupère toutes les catégories pour le menu déroulant des filtres
        $categories = Categorie::all();

        // On retourne la vue 
        return view('accueil', compact('produits', 'categories'));
    }

    /**
     * Affiche les détails d'un seul produit
     */
    public function show(Produit $produit)
    {
        // On charge aussi la catégorie et les avis (reviews) du produit
        $produit->load('categorie', 'reviews');
        
        return view('produits.show', compact('produit'));
    }
}