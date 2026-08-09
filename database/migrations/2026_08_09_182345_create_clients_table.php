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
         Schema::create('clients', function (Blueprint $table) {
        $table->id();
        // Clé étrangère vers la table 'users'. Si l'user est supprimé, le client l'est aussi (cascade)
        $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
        $table->string('nom');
        $table->string('prenom');
        $table->string('contact'); // Correspond à "contact" dans le PDF
        $table->text('adresse')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
