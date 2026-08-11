@extends('layouts.app')

@section('title', 'Modifier un Client - Admin')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"> Modifier le client : {{ $client->prenom }} {{ $client->nom }}</h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('admin.clients.update', $client->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Prénom et Nom sur la même ligne -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="prenom" class="form-label">Prénom *</label>
                                <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                                       id="prenom" name="prenom" 
                                       value="{{ old('prenom', $client->prenom) }}" required>
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom *</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" name="nom" 
                                       value="{{ old('nom', $client->nom) }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact -->
                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact (Téléphone)</label>
                            <input type="text" class="form-control @error('contact') is-invalid @enderror" 
                                   id="contact" name="contact" 
                                   value="{{ old('contact', $client->contact) }}">
                            @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Adresse -->
                        <div class="mb-4">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea class="form-control @error('adresse') is-invalid @enderror" 
                                      id="adresse" name="adresse" rows="3">{{ old('adresse', $client->adresse) }}</textarea>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">
                                ← Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                 Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection