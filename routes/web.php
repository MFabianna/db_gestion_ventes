<?php

use App\Http\Controllers\ProduitController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProduitController as AdminProduitController;
use App\Http\Controllers\Admin\VenteController as AdminVenteController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Routes Publiques
Route::get('/', [ProduitController::class, 'index'])->name('accueil');
Route::get('/produits/{produit}', [ProduitController::class, 'show'])->name('produits.show');

// Routes Protégées (Nécessite authentification)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Panier (Client)
    Route::post('/panier/ajouter/{produit}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
    Route::get('/panier', [PanierController::class, 'voirPanier'])->name('panier.voir');
    Route::delete('/panier/{id}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
    
    // Commande et Reçu (Client)
    Route::post('/commande/valider', [VenteController::class, 'validerCommande'])->name('commande.valider');
    Route::get('/recu/{id}', [VenteController::class, 'showRecu'])->name('recu.show');

    // CRUD Admin - Produits
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('produits', AdminProduitController::class);
        Route::resource('ventes', AdminVenteController::class);
        Route::resource('clients', AdminClientController::class);
    });
});

require __DIR__.'/auth.php';