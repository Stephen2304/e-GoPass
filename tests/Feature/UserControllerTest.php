<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_create_a_user()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        // Créer ou récupérer le rôle admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $response = $this->postJson('/api/users', [
            'nom' => 'John',
            'prenom' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => $adminRole->id, // Assurez-vous que le rôle existe
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_update_a_user()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        // Créer ou récupérer le rôle admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $user = User::create([
            'nom' => 'Jane',
            'prenom' => 'Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id, // Assurez-vous que le rôle existe
        ]);

        $response = $this->putJson("/api/users/{$user->id}", [
            'nom' => 'Jane Updated',
            'prenom' => 'Doe Updated',
            'role_id' => $adminRole->id, // Assurez-vous que le rôle existe
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'email' => 'jane@example.com',
            'nom' => 'Jane Updated',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_show_a_user()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        $user = User::create([
            'nom' => 'Mark',
            'prenom' => 'Smith',
            'email' => 'mark@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['email' => 'mark@example.com']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_delete_a_user()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        $user = User::create([
            'nom' => 'Alice',
            'prenom' => 'Johnson',
            'email' => 'alice@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', [
            'email' => 'alice@example.com',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_list_users()
    {
        $this->actingAs(User::factory()->super_admin()->create()); // Crée un utilisateur super-admin

        User::factory()->count(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200);
        $this->assertCount(4, $response->json('data'));
    }
} 