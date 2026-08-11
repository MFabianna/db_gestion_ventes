@extends('layouts.app')

@section('title', 'Dashboard Admin - CROWN')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tableau de Bord </h1>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Ventes du mois -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-gray-500 text-sm">Ventes ce mois</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalVentesMois }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <span class="text-2xl"></span>
                </div>
            </div>
        </div>

        <!-- Chiffre d'affaires -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-gray-500 text-sm">Chiffre d'affaires</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($chiffreAffaires, 0, ',', ' ') }} Ar</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <span class="text-2xl"></span>
                </div>
            </div>
        </div>

        <!-- Total Clients -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-gray-500 text-sm">Total Clients</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $totalClients }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <span class="text-2xl"></span>
                </div>
            </div>
        </div>

        <!-- Total Produits -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-gray-500 text-sm">Total Produits</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $totalProduits }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <span class="text-2xl"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Produits -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4"> Top 5 Produits</h2>
            <ul class="space-y-3">
                @foreach($topProduits as $index => $produit)
                    <li class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div class="flex items-center">
                            <span class="text-lg font-bold text-purple-600 mr-3">#{{ $index + 1 }}</span>
                            <span class="text-gray-800">{{ $produit->nom }}</span>
                        </div>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $produit->total_vendu }} vendus
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Clients Récents -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4"> Clients Récents</h2>
            <ul class="space-y-3">
                @foreach($clientsRecents as $client)
                    <li class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $client->prenom }} {{ $client->nom }}</p>
                            <p class="text-sm text-gray-500">{{ $client->user->email }}</p>
                        </div>
                        <span class="text-xs text-gray-400">{{ $client->created_at->format('d/m') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Ventes Récentes -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4"> Ventes Récentes</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($ventesRecentes as $vente)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $vente->code_vente }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $vente->client->prenom }} {{ $vente->client->nom }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($vente->montant, 0, ',', ' ') }} Ar</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $vente->date_vente->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $vente->statut === 'payé' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $vente->statut }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $ventesRecentes->links() }}
        </div>
    </div>
</div>
@endsection