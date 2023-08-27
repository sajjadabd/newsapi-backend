<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use \App\Models\User;

class AuthenticatedApiRoutesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function testValidateTokenRoute()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/validate-token');

        $response->assertStatus(200); 
    }

    public function testLogoutRoute()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(200); 
    }

    public function testGetPreferencesRoute()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/preferences');

        $response->assertStatus(200); 
    }

    public function testUpdatePreferencesRoute()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $newPreferences = [
            // provide new preferences data
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson('/api/preferences', $newPreferences);

        $response->assertStatus(200); 
    }

    public function testGetArticlesRoute()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/articles');

        $response->assertStatus(200); 
    }


}
