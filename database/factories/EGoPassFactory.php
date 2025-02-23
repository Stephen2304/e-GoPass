<?php

namespace Database\Factories;

use App\Models\EGoPass;
use Illuminate\Database\Eloquent\Factories\Factory;

class EGoPassFactory extends Factory
{
    protected $model = EGoPass::class;

    public function definition()
    {
        return [
            'numero' => $this->faker->unique()->word(),
            'type' => 'Type1',
            'statut' => 'Active',
            'date_generation' => now()->format('Y-m-d'),
            'user_id' => \App\Models\User::factory(), // Crée un utilisateur associé
            'voyageur_id' => \App\Models\Voyageur::factory(), // Crée un voyageur associé
        ];
    }
} 