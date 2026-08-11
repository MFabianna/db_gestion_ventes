@extends('layouts.app')

@section('title', 'Reçu de commande - CROWN')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-xl p-8">
        <div class="text-center border-b pb-6 mb-6">
            <h1 class="text-3xl font-bold text-purple-600"> CROWN</h1>
            <p class="text-gray-500 mt-2">Reçu de commande</p>
            <p class="text-xl font-semibold text-gray-800 mt-4">Code : {{ $vente->code_vente }}</p>
            <p class="text-sm text-gray-500">Date : {{ $vente->date_vente->format('d/m/Y à H:i') }}</p>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Client</h3>
            <p class="text-gray-600">{{ $vente->client->prenom }} {{ $vente->client->nom }}</p>
            <p class="text-gray-600">{{ $vente->client->user->email }}</p>
        </div>

        <table class="w-full mb-6">
            <thead class="border-b-2 border-gray-300">
                <tr>
                    <th class="text-left py-2 text-gray-600">Produit</th>
                    <th class="text-center py-2 text-gray-600">Qté</th>
                    <th class="text-right py-2 text-gray-600">Prix Unitaire</th>
                    <th class="text-right py-2 text-gray-600">Sous-total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vente->produits as $produit)
                    <tr class="border-b border-gray-200">
                        <td class="py-3 text-gray-800">{{ $produit->nom }}</td>
                        <td class="py-3 text-center text-gray-600">{{ $produit->pivot->quantite }}</td>
                        <td class="py-3 text-right text-gray-600">{{ number_format($produit->pivot->prix_unitaire, 0, ',', ' ') }} Ar</td>
                        <td class="py-3 text-right font-semibold text-gray-800">{{ number_format($produit->pivot->sous_total, 0, ',', ' ') }} Ar</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-between items-center border-t-2 border-purple-600 pt-4">
            <span class="text-2xl font-bold text-gray-800">Total Payé</span>
            <span class="text-3xl font-bold text-purple-600">{{ number_format($vente->montant, 0, ',', ' ') }} Ar</span>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('accueil') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">Retour à l'accueil</a>
        </div>
    </div>
</div>
@endsection