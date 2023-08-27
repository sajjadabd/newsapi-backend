<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use \App\Models\Article;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'source' => $this->faker->word,
            'source_id' => null, 
            'author' => $this->faker->name,
            'url' => $this->faker->url,
            'urlToImage' => $this->faker->imageUrl,
            'publishedAt' => $this->faker->dateTimeThisMonth,
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
