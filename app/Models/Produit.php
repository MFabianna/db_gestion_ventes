<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    // Les colonnes qu'on a le droit de remplir (mass assignment)
    protected $fillable = [
        'nom',
        'description',
        'prix',
        'quantite_stock',
        'categorie_id',
        'image',
    ];

    // 1. Un Produit appartient à une Catégorie
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    // 2. Relation avec les avis (reviews)
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 3. Un Produit est dans plusieurs Ventes (via la table vente_produits)
    public function ventes()
    {
        return $this->belongsToMany(Vente::class, 'vente_produits')
                    ->withPivot('quantite', 'prix_unitaire', 'sous_total')
                    ->withTimestamps();
    }
}