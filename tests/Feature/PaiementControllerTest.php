<?php

namespace Tests\Feature;

use App\Models\Paiement;
use App\Models\User;
use App\Models\EGoPass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaiementControllerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_create_a_paiement()
    {
        $this->actingAs(User::factory()->admin()->create()); // Crée un utilisateur admin
        $eGoPass = EGoPass::factory()->create();

        $response = $this->postJson('/api/paiements', [
            'montant' => 100,
            'user_id' => auth()->id(),
            'mode_paiement' => "CARTE DE CREDIT",
            'reference' => \App\Models\Paiement::generateReference(),
            'statut' => 'PENDING',
            'e_go_passes_id' => $eGoPass->id,
        ]);

        // dd($eGoPass->paiement);

        $response->assertStatus(201);
        $this->assertDatabaseHas('paiements', [
            'montant' => 100,
            'e_go_passes_id' => $eGoPass->id,
        ]);

        // Vérifiez que l'EGoPass a un paiement associé
        $this->assertNotNull($eGoPass->paiement); // Vérifie qu'il y a un paiement associé
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_update_a_paiement()
    {
        $this->actingAs(User::factory()->admin()->create()); // Crée un utilisateur admin
        $eGoPass = EGoPass::factory()->create();

        $paiement = Paiement::factory()->create(['e_go_passes_id' => $eGoPass->id, 'statut' => 'PENDING']);

        $response = $this->putJson("/api/paiements/{$paiement->id}", [
            'statut' => 'COMPLETED', // Mettre à jour uniquement le statut
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('paiements', [
            'id' => $paiement->id,
            'statut' => 'COMPLETED', // Vérifiez que le statut a été mis à jour
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_show_a_paiement()
    {
        $this->actingAs(User::factory()->admin()->create()); // Crée un utilisateur admin

        $paiement = Paiement::factory()->create();

        $response = $this->getJson("/api/paiements/{$paiement->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Paiement trouvé', // Assurez-vous que ce message correspond à la réponse réelle
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_delete_a_paiement()
    {
        $this->actingAs(User::factory()->admin()->create()); // Crée un utilisateur admin

        $paiement = Paiement::factory()->create();

        $response = $this->deleteJson("/api/paiements/{$paiement->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('paiements', [
            'id' => $paiement->id,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_list_paiements()
    {
        $this->actingAs(User::factory()->admin()->create()); // Crée un utilisateur admin

        Paiement::factory()->count(3)->create();

        $response = $this->getJson('/api/paiements');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_filter_payments_by_ego_pass_number()
    {
        $this->actingAs(User::factory()->admin()->create()); // Crée un utilisateur admin

        $eGoPass = EGoPass::factory()->create(['numero' => 'EGOPASS123']);
        $paiement1 = Paiement::factory()->create(['e_go_passes_id' => $eGoPass->id]);
        $paiement2 = Paiement::factory()->create(); // Un paiement sans EGoPass

        $response = $this->getJson('/api/paiements?e_go_pass_number=EGOPASS123');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data')); // Vérifie qu'un seul paiement est retourné
        $this->assertEquals($paiement1->id, $response->json('data.0.id')); // Vérifie que c'est le bon paiement
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_download_paiements_pdf()
    {
        $this->actingAs(User::factory()->admin()->create()); // Crée un utilisateur admin

        $eGoPass = EGoPass::factory()->create();
        $paiement1 = Paiement::factory()->create(['e_go_passes_id' => $eGoPass->id]);
        $paiement2 = Paiement::factory()->create(['e_go_passes_id' => $eGoPass->id]);

        $response = $this->get('/api/download/paiements');

        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
        
        // Vérifiez que le nom de fichier est correct dans l'en-tête Content-Disposition
        $this->assertStringContainsString('filename=paiements.pdf', $response->headers->get('Content-Disposition'));
    }
}
