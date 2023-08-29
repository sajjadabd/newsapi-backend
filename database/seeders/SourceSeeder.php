<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use \App\Models\Source;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
        $sources = [
            [
                'slug' => 'bbc-news',
                'title' => 'BBC News',
            ],
            [
                'slug' => 'cnn',
                'title' => 'CNN',
            ],
            [
                'slug' => 'reuters',
                'title' => 'Reuters',
            ],
            [
                'slug' => 'vice-news',
                'title' => 'VICE News'
            ]
        ];

        foreach ($sources as $source) {
            Source::create($source);
        }
    }
}
