<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'description'];

    //Une Catégorie a plusieurs Produits
    public function produits() { 
        return $this->hasMany(Produit::class); 
    }
}
