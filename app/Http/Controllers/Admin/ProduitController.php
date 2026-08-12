<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index(Request $request)
{
    $query = Produit::with('categorie');

    // Filtre de recherche par nom
    if ($request->has('search') && $request->search != '') {
        $query->where('nom', 'LIKE', '%' . $request->search . '%');
    }

    // Filtre par catégorie
    if ($request->has('categorie') && $request->categorie != '') {
        $query->where('categorie_id', $request->categorie);
    }

    // Filtre par prix minimum
    if ($request->has('prix_min') && $request->prix_min != '') {
        $query->where('prix', '>=', $request->prix_min);
    }

    // Filtre par prix maximum
    if ($request->has('prix_max') && $request->prix_max != '') {
        $query->where('prix', '<=', $request->prix_max);
    }

    $produits = $query->latest()->get();
    $categories = Categorie::all();

    return view('accueil', compact('produits', 'categories'));
}

    public function create()
    {
        $categories = Categorie::all();
        return view('admin.produits.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'quantite_stock' => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        Produit::create($data);

        // Redirection automatique vers la liste avec un message de succès
        return redirect()->route('admin.produits.index')->with('success', 'Produit ajouté avec succès ! 👑');
    }

    public function edit(Produit $produit)
    {
        $categories = Categorie::all();
        return view('admin.produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, Produit $produit)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'quantite_stock' => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update($data);

        return redirect()->route('admin.produits.index')->with('success', 'Produit mis à jour avec succès ! 👑');
    }

    public function destroy(Produit $produit)
    {
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }
        $produit->delete();

        return redirect()->route('admin.produits.index')->with('success', 'Produit supprimé avec succès ! 🗑️');
    }
}