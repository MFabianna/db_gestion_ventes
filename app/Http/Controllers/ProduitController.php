<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    // 1. Page d'accueil (Catalogue avec PAGINATION)
    public function index()
    {
        $produits = Produit::with('categorie')->latest()->paginate(9);
        return view('welcome', compact('produits'));
    }

    // 2. Page de détail d'un produit
    public function show(Produit $produit)
    {
        $produit->load(['categorie', 'reviews.client']);
        $reviews = $produit->reviews()->with('client')->latest()->paginate(5);
        
        return view('produits.show', compact('produit', 'reviews'));
    }
}