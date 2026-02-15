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
        Schema::create('configuration_seuils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unite_id')->unique()->constrained('unites')->onDelete('cascade');
            $table->decimal('valeur_alerte', 10, 2);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuration_seuils');
    }
};
