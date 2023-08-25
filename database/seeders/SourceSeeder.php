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
        ];

        foreach ($sources as $source) {
            Source::create($source);
        }
    }
}
