<?php

namespace Database\Factories;

use App\Models\Paiement;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaiementFactory extends Factory
{
    protected $model = Paiement::class;

    public function definition()
    {
        return [
            'montant' => $this->faker->randomFloat(2, 10, 1000),
            'user_id' => \App\Models\User::factory(), // Crée un utilisateur associé
            'mode_paiement' => $this->faker->randomElement(['CARTE DE CREDIT', 'PAYPAL']),
            'reference' => $this->faker->unique()->word(),
            'statut' => 'PENDING',
        ];
    }
} 