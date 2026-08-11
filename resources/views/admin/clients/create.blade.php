@extends('layouts.app')
@section('title', 'Ajouter un Client - Admin')
@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6"> Ajouter un nouveau client</h1>
        <form action="{{ route('admin.clients.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email (pour la connexion) *</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
                <input type="password" name="password" required class="w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Contact</label>
                <input type="text" name="contact" value="{{ old('contact') }}" class="w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                <textarea name="adresse" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('adresse') }}</textarea>
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="flex-1 bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition"> Enregistrer</button>
                <a href="{{ route('admin.clients.index') }}" class="flex-1 bg-gray-300 text-gray-800 text-center px-6 py-3 rounded-lg hover:bg-gray-400 transition">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection