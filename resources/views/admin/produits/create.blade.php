@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Ajouter un Produit </h1>

    <form action="{{ route('admin.produits.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nom du produit</label>
            <input type="text" name="nom" class="w-full px-3 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg" required></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Prix (Ar)</label>
                <input type="number" name="prix" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Stock</label>
                <input type="number" name="quantite_stock" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Catégorie</label>
            <select name="categorie_id" class="w-full px-3 py-2 border rounded-lg" required>
                <option value="">-- Choisir une catégorie --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Image (optionnel)</label>
            <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border rounded-lg">
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg">
                Enregistrer
            </button>
            <a href="{{ route('admin.produits.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection