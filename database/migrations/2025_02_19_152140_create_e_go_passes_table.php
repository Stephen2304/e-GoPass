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
        Schema::create('e_go_passes', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->string('type');
            $table->string('statut');
            $table->dateTime('date_generation');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('voyageur_id')->constrained('voyageurs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_go_passes');
    }
};
