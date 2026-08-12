<?php

use App\Http\Controllers\ProduitController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProduitController as AdminProduitController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\VenteController as AdminVenteController;
use Illuminate\Support\Facades\Route;

// 1. Routes Publiques (Tout le monde peut voir)
Route::get('/', [ProduitController::class, 'index'])->name('accueil');
Route::get('/produits/{produit}', [ProduitController::class, 'show'])->name('produits.show');

// 2. Routes pour les Clients Connectés (Panier, Commandes)
Route::middleware(['auth'])->group(function () {
    Route::post('/panier/ajouter/{produit}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
    Route::get('/panier', [PanierController::class, 'index'])->name('panier.voir');
    Route::delete('/panier/{item}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
    
    Route::post('/commande/valider', [VenteController::class, 'valider'])->name('commande.valider');
    Route::get('/commande/recu/{vente}', [VenteController::class, 'recu'])->name('commande.recu');
});

// 3. Routes pour l'Admin (Protégées)
// Note: On utilise un middleware 'admin' simple pour l'instant, ou on vérifiera le rôle dans le contrôleur
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Produits
    Route::get('/produits', [AdminProduitController::class, 'index'])->name('produits.index');
    Route::get('/produits/create', [AdminProduitController::class, 'create'])->name('produits.create');
    Route::post('/produits', [AdminProduitController::class, 'store'])->name('produits.store');
    Route::get('/produits/{produit}/edit', [AdminProduitController::class, 'edit'])->name('produits.edit');
    Route::put('/produits/{produit}', [AdminProduitController::class, 'update'])->name('produits.update');
    Route::delete('/produits/{produit}', [AdminProduitController::class, 'destroy'])->name('produits.destroy');

    // CRUD Clients
    Route::get('/clients', [AdminClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [AdminClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [AdminClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}/edit', [AdminClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}', [AdminClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [AdminClientController::class, 'destroy'])->name('clients.destroy');

    // Ventes (Lecture seule pour l'admin)
    Route::get('/ventes', [AdminVenteController::class, 'index'])->name('ventes.index');
    Route::get('/ventes/{vente}', [AdminVenteController::class, 'show'])->name('ventes.show');
});

//les routes d'auth de Breeze
require __DIR__.'/auth.php';