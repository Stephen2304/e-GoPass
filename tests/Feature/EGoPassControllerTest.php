<?php

namespace Tests\Feature;

use App\Models\EGoPass;
use App\Models\User;
use App\Models\Voyageur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EGoPassControllerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_generate_an_ego_pass()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        $voyageur = Voyageur::factory()->create();

        $response = $this->postJson('/api/egopass/generate', [
            'numero' => 'EGOPASS123',
            'type' => 'Type1',
            'statut' => 'Active',
            'date_generation' => now()->format('Y-m-d'),
            'voyageur_id' => $voyageur->id,
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'message' => 'e-GoPass généré avec succès', // Assurez-vous que ce message correspond à la réponse réelle
        ]);
    }
} 