<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\User;
use \App\Models\Article;

use App\Http\Resources\ArticleResource;

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

        $articleResources = ArticleResource::collection($articles);

        return response()->json([
            'articles' => $articleResources ,
            'userSources' => $user->sources,
            'userCategories' => $user->categories,
        ]);
        
    }
}
