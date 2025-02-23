<?php

namespace Database\Factories;

use App\Models\Abonne;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbonneFactory extends Factory
{
    protected $model = Abonne::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'ville' => $this->faker->city(),
            'telephone' => $this->faker->phoneNumber(),
            // Ajoutez d'autres champs nécessaires
        ];
    }
} 