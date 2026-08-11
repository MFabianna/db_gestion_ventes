<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('client_id')->constrained()->onDelete('cascade');
        $table->foreignId('produit_id')->constrained()->onDelete('cascade');
        $table->tinyInteger('note'); // Note de 1 à 5
        $table->text('commentaire')->nullable();
        $table->timestamps();
        
        // Empêche un client de mettre 2 avis sur le même produit
        $table->unique(['client_id', 'produit_id']); 
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
