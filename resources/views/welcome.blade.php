@extends('layouts.app')

@section('title', 'Accueil - CROWN')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg shadow-xl p-8 mb-8 text-white">
        <h1 class="text-4xl font-bold mb-4">Bienvenue chez CROWN </h1>
        <p class="text-xl">Découvrez nos produits capillaires 100% naturels pour des cheveux sublimes</p>
    </div>

    <!-- Liste des Produits -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Nos Produits</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($produits as $produit)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- Image -->
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    @if($produit->image)
                        <img src="{{ asset('images/produits/' . $produit->image) }}" alt="{{ $produit->nom }}" class="h-full w-full object-cover">
                    @else
                        <span class="text-gray-400 text-6xl"></span>
                    @endif
                </div>

                <!-- Contenu -->
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $produit->nom }}</h3>
                    <p class="text-sm text-gray-600 mb-2">{{ Str::limit($produit->description, 80) }}</p>
                    
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-purple-600 font-bold text-xl">{{ number_format($produit->prix, 0, ',', ' ') }} Ar</span>
                        @if($produit->quantite_stock > 0)
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                En stock ({{ $produit->quantite_stock }})
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                Rupture
                            </span>
                        @endif
                    </div>

                    <div class="flex space-x-2">
                        <a href="{{ route('produits.show', $produit->id) }}" 
                           class="flex-1 bg-gray-200 text-gray-800 text-center px-4 py-2 rounded-md hover:bg-gray-300 transition">
                            Voir détails
                        </a>
                        @auth
                            @if($produit->quantite_stock > 0)
                                <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">
                                        Ajouter
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="flex-1 bg-purple-600 text-white text-center px-4 py-2 rounded-md hover:bg-purple-700 transition">
                                Connectez-vous
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500 text-xl">Aucun produit disponible pour le moment.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $produits->links() }}
    </div>
</div>
@endsection