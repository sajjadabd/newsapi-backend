<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use \App\Models\User;
use \App\Models\Article;
use \App\Models\Source;
use \App\Models\Category;


class ArticleControllerTest extends TestCase
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


    public function testGetArticlesBasedOnPreferences()
    {
        // Create a user with preferred sources and categories
        $user = User::factory()->create();
        $preferredSources = Source::factory(2)->create();
        $preferredCategories = Category::factory(2)->create();
        $user->sources()->sync($preferredSources);
        $user->categories()->sync($preferredCategories);






        $nonPreferredSourceArticle = Article::factory()->create();
 
        $preferredSourceArticle = Article::factory()->create(['source_id' => $preferredSources[0]->id]);
        
        $anotherPreferredSourceArticle = Article::factory()->create(['source_id' => $preferredSources[1]->id]);


        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $user->access_token])
            ->postJson('/api/articles');

        // dd($response->json());

        $response->assertStatus(200)
            ->assertJsonStructure(['articles'])
            ->assertJsonFragment(['id' => $preferredSourceArticle->id])
            ->assertJsonMissing(['id' => $nonPreferredSourceArticle->id])
            ->assertJsonFragment(['id' => $anotherPreferredSourceArticle->id]);
    }



    public function testGetArticlesWithoutPreferences()
    {
        // Create a user without preferred sources and categories
        $user = User::factory()->create();

        // Create articles
        $article = Article::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $user->access_token])
            ->postJson('/api/articles');


        $response->assertStatus(200)
            ->assertJsonStructure(['articles']);
            // ->assertJsonFragment(['id' => $article->id]);
    }



}
