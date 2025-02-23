<?php

namespace Database\Factories;

use App\Models\Voyageur;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoyageurFactory extends Factory
{
    protected $model = Voyageur::class;

    public function definition()
    {
        return [
            'type_vol' => $this->faker->randomElement(['aller', 'retour']),
            'numero_eGoPASS' => $this->faker->unique()->randomFloat(2, 10, 1000),
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'post_nom' => $this->faker->lastName(),
            'nationalite' => $this->faker->country(),
            'numero_passport' => $this->faker->unique()->randomFloat(2, 10, 1000),
            'compagnie_aerienne' => $this->faker->company(),
            'numero_vol' => $this->faker->word(),
            'provenance' => $this->faker->city(),
            'destination' => $this->faker->city(),
            'telephone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'adresse_residence' => $this->faker->address(),
        ];
    }
} 