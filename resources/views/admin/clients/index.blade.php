@extends('layouts.app')
@section('title', 'Gestion des Clients - Admin')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800"> Gestion des Clients</h1>
        <a href="{{ route('admin.clients.create') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">➕ Ajouter un client</a>
    </div>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($clients as $client)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $client->prenom }} {{ $client->nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->contact }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.clients.edit', $client->id) }}" class="text-blue-600 hover:text-blue-900 mr-3"> Modifier</a>
                            <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Supprimer ce client ?')"> Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucun client trouvé</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $clients->links() }}</div>
</div>
@endsection