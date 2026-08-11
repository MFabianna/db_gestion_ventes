<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
     protected $fillable = [
        'categorie_id',
        'nom',
        'description',
        'prix',
        'quantite_stock',
        'image',
    ];

    //Un Produit appartient à une Catégorie
    public function categorie() {
        return $this->belongsTo(Categorie::class); 
    }

    // Un Produit est dans plusieurs Ventes (via la table vente_produits)
    public function ventes()
    {
        return $this->belongsToMany(Vente::class, 'vente_produits')
                    ->withPivot('quantite', 'prix_unitaire', 'sous_total')
                    ->withTimestamps();
    }
}
