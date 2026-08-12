<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vente;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    public function index()
    {
        $ventes = Vente::with(['client.user', 'produits'])->latest()->paginate(15);
        return view('admin.ventes.index', compact('ventes'));
    }

    public function show(Vente $vente)
    {
        $vente->load(['client.user', 'produits']);
        return view('admin.ventes.show', compact('vente'));
    }
}