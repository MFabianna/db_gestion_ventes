<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    // Afficher la page d'accueil avec tous les produits
    public function index()
    {
        $produits = Produit::with('categorie')->latest()->paginate(12);
        $categories = Categorie::all();
        
        return view('welcome', compact('produits', 'categories'));
    }

    // Afficher le détail d'un produit
    public function show(Produit $produit)
    {
        $produit->load('categorie', 'reviews');
        
        return view('produits.show', compact('produit'));
    }
}