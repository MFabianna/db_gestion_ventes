@extends('layouts.app')

@section('title', 'Mon Panier - CROWN')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">🛒 Mon Panier</h1>

    @if($panier->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <p class="text-gray-500 text-xl mb-4">Votre panier est vide</p>
            <a href="{{ route('accueil') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                Continuer les achats
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Liste des articles -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($panier as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center mr-3">
                                                @if($item->produit->image)
                                                    <img src="{{ asset('images/produits/' . $item->produit->image) }}" alt="{{ $item->produit->nom }}" class="h-full w-full object-cover rounded">
                                                @else
                                                    <span class="text-2xl"></span>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $item->produit->nom }}</p>
                                                <p class="text-sm text-gray-500">{{ $item->produit->categorie->nom }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($item->produit->prix, 0, ',', ' ') }} Ar
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->quantite }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        {{ number_format($item->produit->prix * $item->quantite, 0, ',', ' ') }} Ar
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('panier.supprimer', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Supprimer cet article ?')">
                                             Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Résumé de la commande -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Résumé de la commande</h2>
                    
                    <div class="border-t border-b py-4 mb-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Sous-total</span>
                            <span class="font-semibold">{{ number_format($total, 0, ',', ' ') }} Ar</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Livraison</span>
                            <span class="font-semibold text-green-600">Gratuite</span>
                        </div>
                    </div>

                    <div class="flex justify-between mb-6">
                        <span class="text-xl font-bold text-gray-800">Total</span>
                        <span class="text-2xl font-bold text-purple-600">{{ number_format($total, 0, ',', ' ') }} Ar</span>
                    </div>

                    <form action="{{ route('commande.valider') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                             Valider la commande
                        </button>
                    </form>

                    <a href="{{ route('accueil') }}" class="block text-center mt-4 text-purple-600 hover:text-purple-800">
                        ← Continuer les achats
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection