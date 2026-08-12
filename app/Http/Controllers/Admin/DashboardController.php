<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Vente;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $totalProduits = Produit::count();
        $totalClients = Client::count();
        $totalVentes = Vente::count();
        
        // Chiffre d'affaires total
        $caTotal = Vente::where('statut', 'payé')->sum('montant');
        
        // Ventes du mois en cours
        $totalVentesMois = Vente::whereMonth('date_vente', now()->month)
                                ->whereYear('date_vente', now()->year)
                                ->count();
        
        // CA du mois en cours
        $caMois = Vente::whereMonth('date_vente', now()->month)
                       ->whereYear('date_vente', now()->year)
                       ->where('statut', 'payé')
                       ->sum('montant');
        
        // Produits en rupture de stock
        $produitsRupture = Produit::where('quantite_stock', '<=', 0)->count();
        
        // Dernières ventes
        $dernieresVentes = Vente::with('client.user')
                                ->latest()
                                ->take(5)
                                ->get();
        
        return view('admin.dashboard', compact(
            'totalProduits',
            'totalClients',
            'totalVentes',
            'caTotal',
            'totalVentesMois',
            'caMois',
            'produitsRupture',
            'dernieresVentes'
        ));
    }
}