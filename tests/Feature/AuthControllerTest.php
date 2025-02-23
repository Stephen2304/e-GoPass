<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_login_a_user()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'nom',
                'prenom',
                'email',
                'role',
                'telephone',
                'token',
            ],
            'message',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_logout_a_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/auth/logout');

        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'data' => [],
            'message' => 'You Logged out',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_verify_token()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/auth/verify-token');

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Token is valid',
        ]);
    }
} 