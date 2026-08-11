<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vente;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVentesMois = Vente::whereMonth('date_vente', now()->month)
                                ->whereYear('date_vente', now()->year)
                                ->count();
        
        $chiffreAffaires = Vente::whereMonth('date_vente', now()->month)->sum('montant');
        
        $totalClients = Client::count();
        $totalProduits = Produit::count();

        $topProduits = DB::table('vente_produits')
            ->join('produits', 'vente_produits.produit_id', '=', 'produits.id')
            ->select('produits.nom', DB::raw('SUM(vente_produits.quantite) as total_vendu'))
            ->groupBy('produits.id', 'produits.nom')
            ->orderByDesc('total_vendu')
            ->limit(5)
            ->get();

        $clientsRecents = Client::with('user')->latest()->limit(5)->get();

        $ventesRecentes = Vente::with('client.user')->latest()->paginate(10);

        return view('admin.dashboard', compact(
            'totalVentesMois', 'chiffreAffaires', 'totalClients', 'totalProduits',
            'topProduits', 'clientsRecents', 'ventesRecentes'
        ));
    }
}