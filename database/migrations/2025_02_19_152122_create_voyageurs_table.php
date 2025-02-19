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
            $table->string('nom');
            $table->string('postnom')->nullable();
            $table->string('prenom');
            $table->string('nationalite');
            $table->string('passport_num')->unique();
            $table->date('date_delivrance');
            $table->string('tel');
            $table->string('email')->nullable();
            $table->string('adresse')->nullable();
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
