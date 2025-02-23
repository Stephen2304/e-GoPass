<?php

namespace Tests\Feature;

use App\Models\Abonne;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbonneControllerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_create_an_abonne()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        $response = $this->postJson('/api/abonnes', [
            'nom' => 'Abonne',
            'prenom' => 'Test',
            'email' => 'Test@gmail.com',
            'ville' => 'Yaoundé',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'nom',
                'prenom',
                'email',
                'ville',
            ],
            'message',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_update_an_abonne()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        $abonne = Abonne::factory()->create();

        $response = $this->putJson("/api/abonnes/{$abonne->id}", [
            'nom' => 'Abonne Updated',
            'prenom' => 'Test',
            'email' => 'Test@gmail.com',
            'ville' => 'Yaoundé',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'nom',
                'prenom',
                'email',
                'ville',
            ],
            'message',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_show_an_abonne()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        $abonne = Abonne::factory()->create();

        $response = $this->getJson("/api/abonnes/{$abonne->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'nom',
                'prenom',
                'email',
                'ville',
            ],
            'message',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_delete_an_abonne()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        $abonne = Abonne::factory()->create();

        $response = $this->deleteJson("/api/abonnes/{$abonne->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('voyageurs', [
            'id' => $abonne->id,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_list_abonnes()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        Abonne::factory()->count(3)->create();

        $response = $this->getJson('/api/abonnes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                '*' => [
                    'id',
                    'nom',
                    'prenom',
                    'email',
                    'ville',
                ],
            ],
            'message',
        ]);
    }
} 