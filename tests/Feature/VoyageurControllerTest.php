<?php

namespace Tests\Feature;

use App\Models\Voyageur;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoyageurControllerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_create_a_voyageur()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        $response = $this->postJson('/api/voyageurs', [
            'nom' => 'Jean',
            'prenom' => 'Dupont',
            'email' => 'jean.dupont@example.com',
            'telephone' => '0123456789',
            'adresse' => '123 Rue de Paris',
            'type_vol' => 'aller-retour',
            'numero_eGoPASS' => 6574984165,
            'post_nom' => 'Dupont',
            'nationalite' => 'Française',
            'numero_passport' => '123456789',
            'compagnie_aerienne' => 'Air France',
            'numero_vol' => 'AF1234',
            'provenance' => 'Paris',
            'destination' => 'Londres',
            'adresse_residence' => '456 Avenue des Champs-Élysées',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('voyageurs', [
            'email' => 'jean.dupont@example.com',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_update_a_voyageur()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        $voyageur = Voyageur::factory()->create([
            'nom' => 'Marie',
            'prenom' => 'Curie',
            'email' => 'marie.curie@example.com',
            'telephone' => '0987654321',
            'type_vol' => 'aller-simple',
            'numero_eGoPASS' => 6584951685,
            'post_nom' => 'Curie',
            'nationalite' => 'Française',
            'numero_passport' => '987654321',
            'compagnie_aerienne' => 'Air France',
            'numero_vol' => 'AF5678',
            'provenance' => 'Lyon',
            'destination' => 'Berlin',
            'adresse_residence' => '789 Boulevard Saint-Germain',
        ]);

        $response = $this->putJson("/api/voyageurs/{$voyageur->id}", [
            'nom' => 'Marie Updated',
            'prenom' => 'Curie Updated',
            'email' => 'marie.updated@example.com',
            'telephone' => '0123456789',
            'type_vol' => 'aller-retour',
            'numero_eGoPASS' => 1111111111,
            'post_nom' => 'Curie Updated',
            'nationalite' => 'Française',
            'numero_passport' => '123456789',
            'compagnie_aerienne' => 'Air France',
            'numero_vol' => 'AF1234',
            'provenance' => 'Marseille',
            'destination' => 'Madrid',
            'adresse_residence' => '456 Rue de Paris',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('voyageurs', [
            'email' => 'marie.updated@example.com',
            'nom' => 'Marie Updated',
            'numero_eGoPASS' => 1111111111,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_show_a_voyageur()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        $voyageur = Voyageur::factory()->create();

        $response = $this->getJson("/api/voyageurs/{$voyageur->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['nom' => $voyageur->nom]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_delete_a_voyageur()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        $voyageur = Voyageur::factory()->create();

        $response = $this->deleteJson("/api/voyageurs/{$voyageur->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('voyageurs', [
            'id' => $voyageur->id,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_list_voyageurs()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        Voyageur::factory()->count(3)->create();

        $response = $this->getJson('/api/voyageurs');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }
} 