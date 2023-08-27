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
    

    
    public function handle()
    {
        $apiKey = env('NEWS_API_KEY');
        
        $sources = [ 
            // 'bbc-news', 
            // 'cnn', 
            // 'reuters', 
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
        ]; 

        $sources = Source::all();
        

        $endpoint = 'https://newsapi.org/v2/top-headlines';
        $source_endpoint = 'https://newsapi.org/v2/top-headlines/sources';

        $client = new Client([
            'verify' => false,
        ]);



        foreach($sources as $source) {

            $response = $client->get($endpoint, [
                'query' => [
                    'apiKey' => $apiKey,
                    //'country' => 'us',
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
