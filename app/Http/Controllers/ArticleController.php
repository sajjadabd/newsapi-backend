<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\User;
use \App\Models\Article;

class ArticleController extends Controller
{
    // Get articles based on user's preferences
    public function getArticles(Request $request)
    {
        $user = $request->user;
        
        $preferredSources = $user->sources->pluck('id');
        $preferredCategories = $user->categories->pluck('id');

        $articles = Article::whereHas('source', function ($query) use ($preferredSources) {
            $query->whereIn('id', $preferredSources);
        })->get();


        return response()->json([
            'articles' => $articles ,
            'userSources' => $user->sources,
            'userCategories' => $user->categories,
        ]);
        
    }
}
