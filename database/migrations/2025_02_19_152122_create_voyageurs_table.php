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
        Schema::create('voyageurs', function (Blueprint $table) {
            $table->id();
            $table->string('type_vol');
            $table->bigInteger('numero_eGoPASS');
            $table->string('nom');
            $table->string('prenom');
            $table->string('post_nom');
            $table->string('nationalite');
            $table->integer('numero_passport');
            $table->string('compagnie_aerienne');
            $table->string('numero_vol');
            $table->string('provenance');
            $table->string('destination');
            $table->string('telephone');
            $table->string('email');
            $table->string('adresse_residence');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voyageurs');
    }
};
