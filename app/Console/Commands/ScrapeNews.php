<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use GuzzleHttp\Client;
use jcobhams\newsapi\NewsAPI;
use \App\Models\Article;

class ScrapeNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape news from NewsAPI and save to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiKey = env('NEWS_API_KEY');
        $sources = ['bbc-news', 'cnn', 'reuters']; // Add more sources as needed

        $newsapi = new NewsAPI($apiKey);

        foreach ($sources as $source) {
            $articles = $newsapi->getEverything([
                'sources' => $source,
            ]);

            foreach ($articles['articles'] as $article) {
                Article::create([
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'source' => $article['source']['name'],
                ]);
            }
        }

        $this->info('News scraped and saved successfully.');
    }

    /*
    public function handle()
    {
        $apiKey = env('NEWS_API_KEY');
        // $sources = ['bbc-news', 'cnn', 'reuters']; // Add more sources as needed
        $endpoint = 'https://newsapi.org/v2/top-headlines';
        
        $client = new Client();
        $response = $client->get($endpoint, [
            'query' => [
                'apiKey' => $apiKey,
                'country' => 'us', // adjust based on your needs
                'sources' => $source,
            ]
        ]);
        
        $articles = json_decode($response->getBody())->articles;

        foreach ($articles as $article) {
            NewsArticle::create([
                'title' => $article->title,
                'description' => $article->description,
                'source' => $article->source->name,
            ]);
        }

        $this->info('News scraped and saved successfully.');
    }
    */
}
