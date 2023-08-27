<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class AuthControllerTest extends TestCase
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


    public function testRegister()
    {
        $userData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'testpassword',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id', 'username', 'email', 'created_at', 'updated_at'],
                'access_token',
            ]);
    }

    public function testValidateToken()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $user->access_token])
            ->postJson('/api/validate-token');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id', 'username', 'email', 'created_at', 'updated_at'],
                'valid',
            ]);
    }

    public function testLogin()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('testpassword'),
        ]);

        $credentials = [
            'email' => 'test@example.com',
            'password' => 'testpassword',
        ];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id', 'username', 'email', 'created_at', 'updated_at'],
                'access_token',
            ]);
    }

    public function testLogout()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $user->access_token])
        ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['success' => true, 'message' => 'Logged out successfully']);
    }


}
