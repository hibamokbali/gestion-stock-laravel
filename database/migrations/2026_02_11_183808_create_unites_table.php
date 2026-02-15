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
        Schema::create('unites', function (Blueprint $table) {
            $table->id();
            $table->string('code_unite')->unique();
            $table->string('designation');
            $table->enum('unite_mesure', [
                'pièce', 'boîte', 'paquet', 'rame',
                'kg', 'g', 'litre', 'ml',
                'mètre', 'cm', 'lot', 'rouleau',
                'carton', 'sachet', 'flacon', 'tube'
            ])->default('pièce');
            $table->foreignId('categorie_id')->constrained('categories');
            $table->foreignId('magasin_id')->constrained('magasins');
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unites');
    }
};
