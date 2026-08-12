@extends('layouts.app')

@section('title', 'Accueil - CROWN')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg shadow-xl p-8 mb-8 text-white text-center">
        <h1 class="text-4xl font-bold mb-4">Bienvenue chez CROWN </h1>
        <p class="text-xl">Découvrez nos produits capillaires 100% naturels pour des cheveux sublimes</p>
    </div>

    <!-- Barre de recherche et filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border border-purple-100">
        <form action="{{ url('/') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            <!-- Recherche par nom -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="🔍 Nom du produit..."
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <!-- Filtre par catégorie -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                <select name="categorie" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('categorie') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Prix minimum -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prix min (Ar)</label>
                <input type="number" name="prix_min" value="{{ request('prix_min') }}" 
                    placeholder="0"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <!-- Prix maximum et Bouton -->
            <div class="flex flex-col justify-end">
                <label class="block text-sm font-medium text-gray-700 mb-1">Prix max (Ar)</label>
                <div class="flex gap-2">
                    <input type="number" name="prix_max" value="{{ request('prix_max') }}" 
                        placeholder="Max"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <button type="submit" class="bg-purple-600 text-white font-bold px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                        OK
                    </button>
                </div>
            </div>
        </form>

        <!-- Bouton réinitialiser -->
        @if(request('search') || request('categorie') || request('prix_min') || request('prix_max'))
            <div class="mt-4 text-right">
                <a href="{{ url('/') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium underline">
                    ✖ Réinitialiser les filtres
                </a>
            </div>
        @endif
    </div>

    <!-- Layout principal : Sidebar + Produits -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        
        <!-- 1. SIDEBAR (1 colonne sur grand écran) -->
        <div class="md:col-span-1">
            @include('partials.sidebar')
        </div>

        <!-- 2. LISTE DES PRODUITS (3 colonnes sur grand écran) -->
        <div class="md:col-span-3">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-l-4 border-purple-600 pl-3">Nos Produits</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($produits as $produit)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col">
                        <!-- Image -->
                        <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                            @if($produit->image)
                                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="h-full w-full object-cover hover:scale-105 transition-transform duration-300">
                            @else
                                <span class="text-gray-300 text-6xl">📷</span>
                            @endif
                        </div>

                        <!-- Contenu -->
                        <div class="p-4 flex flex-col flex-grow">
                            <span class="text-xs font-semibold text-purple-600 uppercase tracking-wide mb-1">
                                {{ $produit->categorie->nom ?? 'CROWN' }}
                            </span>
                            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $produit->nom }}</h3>
                            <p class="text-sm text-gray-600 mb-4 flex-grow">{{ Str::limit($produit->description, 60) }}</p>
                            
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-purple-700 font-bold text-xl">{{ number_format($produit->prix, 0, ',', ' ') }} Ar</span>
                                @if($produit->quantite_stock > 0)
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                        Stock: {{ $produit->quantite_stock }}
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">
                                        Rupture
                                    </span>
                                @endif
                            </div>

                            <div class="flex space-x-2 mt-auto">
                                <a href="{{ route('produits.show', $produit->id) }}" 
                                   class="flex-1 bg-gray-100 text-gray-800 text-center px-3 py-2 rounded-md hover:bg-gray-200 transition text-sm font-medium">
                                    Détails
                                </a>
                                @auth
                                    @if($produit->quantite_stock > 0)
                                        <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-purple-600 text-white px-3 py-2 rounded-md hover:bg-purple-700 transition text-sm font-medium">
                                                Ajouter
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" 
                                       class="flex-1 bg-purple-600 text-white text-center px-3 py-2 rounded-md hover:bg-purple-700 transition text-sm font-medium">
                                        Connexion
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 bg-white rounded-lg shadow">
                        <p class="text-gray-500 text-xl"> Aucun produit ne correspond à ta recherche.</p>
                        <a href="{{ url('/') }}" class="text-purple-600 hover:underline mt-2 inline-block">Voir tous les produits</a>
                    </div>
                @endforelse
            </div>

            {{-- <div class="mt-8">
                {{ $produits->links() }}
            </div> --}}
            
        </div>
    </div>
</div>
@endsection