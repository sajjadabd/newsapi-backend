<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use GuzzleHttp\Client;
use jcobhams\NewsApi\NewsApi;
use \App\Models\Article;
use \App\Models\Source;
use \App\Models\Category;

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
    /*
    public function handle()
    {
        $apiKey = env('NEWS_API_KEY');
        $sources = ['bbc-news', 'cnn', 'reuters']; // Add more sources as needed

        $newsapi = new NewsAPI($apiKey);


        // getSources requires a query parameter like 'category'
        $categoryForSource = 'business'; 
        $all_sources = $newsapi->getSources($categoryForSource);
        //$all_categories = $newsapi->getCategories();

        foreach ($all_sources as $source) {
            Source::create([
                'title' => $source['title'],
                'description' => $source['description'],
                'source' => $source['category'],
            ]);
        }

        
        foreach ($all_categories as $category) {
            Category::create([
                'title' => $category['title'],
            ]);
        }
        

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

    */

    
    public function handle()
    {
        $apiKey = env('NEWS_API_KEY');
        
        $sources = [ 
            //'bbc-news', 
            //'cnn', 
            //'reuters', 
            // 'abc-news',
            // 'bloomberg',
            // 'cbs-news',
            // 'fox-news',
            // 'google-news',
            // 'hacker-news',
            // 'independent',
            // 'msnbc',
            // 'nbc-news',
            // 'rt',
            // 'the-washington-post',
            // 'time',
            // 'vice-news',
            // 'wired',
        ]; // Add more sources as needed

        $sources = Source::all();
        

        $endpoint = 'https://newsapi.org/v2/top-headlines';
        $source_endpoint = 'https://newsapi.org/v2/top-headlines/sources';

        $client = new Client([
            'verify' => false,
        ]);


        /*
        $all_sources = $client->get($source_endpoint, [
            'query' => [
                'apiKey' => $apiKey,
            ]
        ]);        
        $all_sources = json_decode($all_sources->getBody())->sources;

        foreach ($all_sources as $source) {
            Source::create([
                'slug' => $source->id,
                'title' => $source->name,
                'description' => $source->description,
                'category' => $source->category,
            ]);
        }
        */

        foreach($sources as $source) {

            $response = $client->get($endpoint, [
                'query' => [
                    'apiKey' => $apiKey,
                    //'country' => 'us', // adjust based on your needs
                    'sources' => $source['slug'],
                ]
            ]);


            $articles = json_decode($response->getBody())->articles;

            
            foreach ($articles as $article) {
                Article::create([
                    'title' => $article->title,
                    'description' => $article->description,
                    'source' => $article->source->name,
                    'source_id' => $source->id,
                ]);
            }

        }
        

        

        $this->info('News scraped and saved successfully.');
    }
    

}
