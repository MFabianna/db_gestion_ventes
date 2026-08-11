<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;
    //FORMAT Y/M/D en D/M/Y
    protected $casts = [
        'date_vente' => 'datetime',
    ];

    protected $fillable = [
        'code_vente',
        'client_id',
        'montant', // Comme demandé dans le PDF
        'date_vente',
        'statut',
    ];

    //Une Vente appartient à un Client
    public function client() { return $this->belongsTo(Client::class); }

    //RELATION PIVOT : Une Vente contient plusieurs Produits
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'vente_produits')
                    ->withPivot('quantite', 'prix_unitaire', 'sous_total')
                    ->withTimestamps();
    }
}
