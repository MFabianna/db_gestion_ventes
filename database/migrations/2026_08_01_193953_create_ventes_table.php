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
        Schema::create('ventes', function (Blueprint $table) {
        $table->id();
        $table->string('code_vente')->unique(); // Notre code personnalisé V-01-08-2026-001
        $table->foreignId('client_id')->constrained()->onDelete('cascade');
        $table->decimal('montant', 10, 2); // "montant" du PDF
        $table->dateTime('date_vente'); // "date" du PDF
        $table->enum('statut', ['payé', 'en attente'])->default('payé');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
