<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use \App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['title' => 'business'],
            ['title' => 'entertainment'],
            ['title' => 'general'],
            ['title' => 'health'],
            ['title' => 'science'],
            ['title' => 'sports'],
            ['title' => 'technology'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }

    // business entertainment general health science sports technology
}
