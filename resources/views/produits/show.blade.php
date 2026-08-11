@extends('layouts.app')

@section('title', $produit->nom . ' - CROWN')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
            <!-- Image -->
            <div class="h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                @if($produit->image)
                    <img src="{{ asset('images/produits/' . $produit->image) }}" alt="{{ $produit->nom }}" class="h-full w-full object-cover rounded-lg">
                @else
                    <span class="text-gray-400 text-9xl"></span>
                @endif
            </div>

            <!-- Informations -->
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $produit->nom }}</h1>
                <p class="text-purple-600 text-sm mb-4">{{ $produit->categorie->nom }}</p>
                
                <div class="flex items-center mb-6">
                    <span class="text-4xl font-bold text-gray-900">{{ number_format($produit->prix, 0, ',', ' ') }} Ar</span>
                    @if($produit->quantite_stock > 0)
                        <span class="ml-4 bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            ✓ En stock ({{ $produit->quantite_stock }})
                        </span>
                    @else
                        <span class="ml-4 bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                             Rupture de stock
                        </span>
                    @endif
                </div>

                <p class="text-gray-600 mb-6">{{ $produit->description }}</p>

                @auth
                    @if($produit->quantite_stock > 0)
                        <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST" class="mb-6">
                            @csrf
                            <button type="submit" class="w-full bg-purple-600 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-purple-700 transition">
                                 Ajouter au panier
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block w-full bg-purple-600 text-white text-center px-6 py-3 rounded-lg text-lg font-semibold hover:bg-purple-700 transition mb-6">
                        Connectez-vous pour acheter
                    </a>
                @endauth

                <!-- Note moyenne -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold mb-3"> Note moyenne : {{ number_format($produit->note_moyenne, 1) }}/5</h3>
                    <p class="text-gray-500">{{ $produit->nombre_avis }} avis</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Avis Clients -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6"> Avis des clients</h2>
        
        @forelse($reviews as $review)
            <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center">
                        <div class="bg-purple-100 rounded-full w-10 h-10 flex items-center justify-center mr-3">
                            <span class="text-purple-600 font-bold">{{ substr($review->client->prenom, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $review->client->prenom }} {{ $review->client->nom }}</p>
                            <p class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $review->note ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                        @endfor
                    </div>
                </div>
                @if($review->commentaire)
                    <p class="text-gray-600 mt-3">{{ $review->commentaire }}</p>
                @endif
            </div>
        @empty
            <div class="bg-gray-50 rounded-lg p-6 text-center">
                <p class="text-gray-500">Aucun avis pour ce produit pour le moment.</p>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection