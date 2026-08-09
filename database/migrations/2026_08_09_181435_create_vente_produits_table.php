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
       Schema::create('vente_produits', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vente_id')->constrained()->onDelete('cascade');
        $table->foreignId('produit_id')->constrained()->onDelete('cascade');
        $table->integer('quantite');
        $table->decimal('prix_unitaire', 10, 2); // Prix au moment de l'achat (important si le prix change plus tard)
        $table->decimal('sous_total', 10, 2);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vente_produits');
    }
};
