<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'contact', 
        'adresse',
    ];

    //REALATIONS
    // Un Client appartient à un User
    public function user() { return $this->belongsTo(User::class); }
    
    //Un Client a plusieurs Ventes
    public function ventes() { return $this->hasMany(Vente::class); }
    
    //Un Client a plusieurs Reviews
    public function reviews() { return $this->hasMany(Review::class); }
    
    // Un Client a plusieurs articles dans son Panier
    public function panier() { return $this->hasMany(Panier::class); }
}
