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
        Schema::create('entrees', function (Blueprint $table) {
            $table->id();
            $table->string('code_entree')->unique();
            $table->foreignId('unite_id')->constrained('unites');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('fournisseur_id')->nullable()->constrained('fournisseurs');
            $table->decimal('quantite', 10, 2);
            $table->date('date_reception');
            $table->string('numero_bon')->nullable();
            $table->string('numero_facture')->nullable();
            $table->decimal('prix_unit', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrees');
    }
};
