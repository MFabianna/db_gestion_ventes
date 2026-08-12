@extends('layouts.app')

@section('title', 'Gestion des Produits - CROWN Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Produits </h1>
        <a href="{{ route('admin.produits.create') }}" 
           class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg shadow">
            + Ajouter un produit
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Image</th>
                    <th class="py-3 px-4 text-left">Nom</th>
                    <th class="py-3 px-4 text-left">Catégorie</th>
                    <th class="py-3 px-4 text-left">Prix (Ar)</th>
                    <th class="py-3 px-4 text-left">Stock</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($produits as $produit)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">
                            @if($produit->image)
                                <img src="{{ asset('storage/' . $produit->image) }}" 
                                     alt="{{ $produit->nom }}" 
                                     class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                                    ?
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-4 font-medium">{{ $produit->nom }}</td>
                        <td class="py-3 px-4">
                            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">
                                {{ $produit->categorie->nom ?? 'Non classé' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ number_format($produit->prix, 0, ',', ' ') }} Ar</td>
                        <td class="py-3 px-4">
                            @if($produit->quantite_stock > 10)
                                <span class="text-green-600 font-bold">{{ $produit->quantite_stock }}</span>
                            @elseif($produit->quantite_stock > 0)
                                <span class="text-yellow-600 font-bold">{{ $produit->quantite_stock }}</span>
                            @else
                                <span class="text-red-600 font-bold">Rupture</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 flex gap-2">
                            <a href="{{ route('admin.produits.edit', $produit->id) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-sm">
                                Modifier
                            </a>
                            <form action="{{ route('admin.produits.destroy', $produit->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit ?');"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500">
                            Aucun produit pour le moment. 
                            <a href="{{ route('admin.produits.create') }}" class="text-purple-600 hover:underline">
                                Ajoutez-en un !
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $produits->links() }}
    </div>
</div>
@endsection