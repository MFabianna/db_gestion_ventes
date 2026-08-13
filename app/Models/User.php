<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relation : Un User a un Client (one-to-one)
     */
    public function client()
    {
        return $this->hasOne(Client::class);
    }

    /**
     * Relation : Un User a plusieurs Paniers via Client (hasManyThrough)
     */
    public function paniers()
    {
        return $this->hasManyThrough(
            Panier::class,
            Client::class,
            'user_id',      // Clé étrangère dans la table clients
            'client_id',    // Clé étrangère dans la table paniers
            'id',           // Clé primaire dans la table users
            'id'            // Clé primaire dans la table clients
        );
    }
}