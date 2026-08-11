<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'produit_id', 'note', 'commentaire'];

    public function client() { 
        return $this->belongsTo(Client::class); 
    }
    
    public function produit() {
         return $this->belongsTo(Produit::class); 
        }
}
