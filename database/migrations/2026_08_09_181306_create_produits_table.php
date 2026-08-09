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
        Schema::create('produits', function (Blueprint $table) {
        $table->id();
        $table->foreignId('categorie_id')->nullable()->constrained()->onDelete('set null');
        $table->string('nom');
        $table->text('description');
        $table->decimal('prix', 10, 2); // 10 chiffres au total, 2 après la virgule (ex: 15000.00)
        $table->integer('quantite_stock')->default(0); // "quantité en stock" du PDF
        $table->string('image')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
