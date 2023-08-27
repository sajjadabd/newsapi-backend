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
        // Fetch articles from the database based on user preferences
        // Return articles in the response
        // Retrieve user's preferred sources and categories

        $access_token = $request->bearerToken(); // Get the access token from the request

        if ($access_token) {
            // Find the user based on the provided access token
            $user = User::where('access_token', $access_token)->first();

            if ($user) {
                
                $preferredSources = $user->sources->pluck('id');
                $preferredCategories = $user->categories->pluck('id');

                // Query articles based on preferred sources and categories
                $articles = Article::whereHas('source', function ($query) use ($preferredSources) {
                    $query->whereIn('id', $preferredSources);
                })
                // ->whereHas('categories', function ($query) use ($preferredCategories) {
                //     $query->whereIn('id', $preferredCategories);
                // })
                //->orderBy('published_at', 'desc')
                // ->take(10) // Limit the number of articles
                ->get();


                return response()->json([
                    'articles' => $articles ,
                ]);


            }
        }

        
    }
}
