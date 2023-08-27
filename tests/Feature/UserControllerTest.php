<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Source;
use App\Models\Category;

class UserControllerTest extends TestCase
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



    public function testGetPreferences()
    {
        $user = User::factory()->create();
        $sources = Source::factory(2)->create();
        $categories = Category::factory(2)->create();

        $user->sources()->sync($sources);
        $user->categories()->sync($categories);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $user->access_token])
        ->postJson('/api/preferences');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'sources' => ['*' => ['id', 'title', 'description', 'category', 'created_at', 'updated_at']],
                'categories' => ['*' => ['id', 'title', 'created_at', 'updated_at']],
                'user_sources' => ['*' => ['id', 'title', 'description', 'category', 'created_at', 'updated_at']],
                'user_categories' => ['*' => ['id', 'title', 'created_at', 'updated_at']],
            ]);
    }

    public function testUpdatePreferences()
    {
        $user = User::factory()->create();
        $sources = Source::factory(2)->create();
        $categories = Category::factory(2)->create();

        $requestData = [
            'sources' => $sources->pluck('id')->toArray(),
            'categories' => $categories->pluck('id')->toArray(),
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $user->access_token])
        ->postJson('/api/preferences', $requestData);

        $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'sources' => ['*' => ['id', 'title', 'description', 'category', 'created_at', 'updated_at']],
            'categories' => ['*' => ['id', 'title', 'created_at', 'updated_at']],
            'user_sources',
            'user_categories',
        ])
        ->assertJsonFragment(['success' => true]);
        // ->assertJsonFragment(['message' => 'Preferences updated successfully.'])
    }



}
