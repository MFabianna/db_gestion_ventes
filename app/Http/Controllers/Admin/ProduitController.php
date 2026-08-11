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

        if ($request->filled('categorie')) {
            $query->where('categorie_id', $request->categorie);
        }

        if ($request->filled('disponibilite')) {
            if ($request->disponibilite === 'en_stock') {
                $query->where('quantite_stock', '>', 0);
            } elseif ($request->disponibilite === 'rupture') {
                $query->where('quantite_stock', '=', 0);
            }
        }

        $produits = $query->latest()->paginate(10);
        $categories = Categorie::all();

        return view('admin.produits.index', compact('produits', 'categories'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/produits'), $imageName);
            $data['image'] = $imageName;
        }

        Produit::create($data);

        return redirect()->route('admin.produits.index')->with('success', 'Produit ajouté avec succès !');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($produit->image) {
                $oldImagePath = public_path('images/produits/' . $produit->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/produits'), $imageName);
            $data['image'] = $imageName;
        } else {
            unset($data['image']);
        }

        $produit->update($data);

        return redirect()->route('admin.produits.index')->with('success', 'Produit modifié avec succès !');
    }

    public function destroy(Produit $produit)
    {
        if ($produit->image) {
            $imagePath = public_path('images/produits/' . $produit->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $produit->delete();

        return redirect()->route('admin.produits.index')->with('success', 'Produit supprimé.');
    }
}