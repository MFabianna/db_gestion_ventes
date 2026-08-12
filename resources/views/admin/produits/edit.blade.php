@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Modifier le Produit </h1>

    <form action="{{ route('admin.produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT') <!-- Très important pour la mise à jour -->

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nom du produit</label>
            <input type="text" name="nom" value="{{ old('nom', $produit->nom) }}" class="w-full px-3 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg" required>{{ old('description', $produit->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Prix (Ar)</label>
                <input type="number" name="prix" value="{{ old('prix', $produit->prix) }}" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Stock</label>
                <input type="number" name="quantite_stock" value="{{ old('quantite_stock', $produit->quantite_stock) }}" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Catégorie</label>
            <select name="categorie_id" class="w-full px-3 py-2 border rounded-lg" required>
                <option value="">-- Choisir une catégorie --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('categorie_id', $produit->categorie_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Image actuelle</label>
            @if($produit->image)
                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="w-32 h-32 object-cover rounded mb-2">
            @else
                <p class="text-gray-500 mb-2">Aucune image</p>
            @endif
            
            <label class="block text-gray-700 font-bold mb-2">Changer l'image (optionnel)</label>
            <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border rounded-lg">
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                Mettre à jour
            </button>
            <a href="{{ route('admin.produits.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection