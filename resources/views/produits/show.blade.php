@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="md:flex">
            <!-- Image du produit -->
            <div class="md:w-1/2 p-6 flex items-center justify-center bg-gray-100">
                @if($produit->image)
                    <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="max-h-96 object-contain rounded">
                @else
                    <div class="text-gray-400 text-6xl"></div>
                @endif
            </div>

            <!-- Détails du produit -->
            <div class="md:w-1/2 p-6">
                <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                    {{ $produit->categorie->nom ?? 'Non classé' }}
                </span>
                
                <h1 class="text-3xl font-bold text-gray-800 mt-2 mb-4">{{ $produit->nom }}</h1>
                
                <p class="text-2xl font-bold text-purple-600 mb-4">
                    {{ number_format($produit->prix, 0, ',', ' ') }} Ar
                </p>
                
                <p class="text-gray-600 mb-6 leading-relaxed">
                    {{ $produit->description }}
                </p>

                <div class="mb-6">
                    @if($produit->quantite_stock > 0)
                        <span class="text-green-600 font-bold"> En stock ({{ $produit->quantite_stock }} disponibles)</span>
                    @else
                        <span class="text-red-600 font-bold"> Rupture de stock</span>
                    @endif
                </div>

                <div class="flex gap-4">
                    @auth
                        <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow">
                                 Ajouter au panier
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-gray-400 text-white font-bold py-3 px-6 rounded-lg shadow cursor-not-allowed">
                            Connectez-vous pour acheter
                        </a>
                    @endauth
                    
                    <a href="{{ url('/') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg">
                        ← Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection