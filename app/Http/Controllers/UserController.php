<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Source;
use \App\Models\Category;
use \App\Models\User;

class UserController extends Controller
{
    // Get user's preferences
    public function getPreferences(Request $request)
    {
        // Fetch user preferences from the database

        $access_token = $request->bearerToken(); // Get the access token from the request

        if ($access_token) {
            // Find the user based on the provided access token
            $user = User::where('access_token', $access_token)->first();

            if ($user) {
                
                $sources = Source::all();
                $categories = Category::all();

                return response()->json([
                    'success' => 'true',
                    'sources' => $sources,
                    'categories' => $categories,
                    'user_sources' => $user->sources,
                    'user_categories' => $user->categories,
                ]);
            }
        }

        // Return preferences in the response



    }

    // Update user's preferences
    public function updatePreferences(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'sources' => 'required',
            'categories' => 'required',
        ]);

        // Update user preferences in the database


        // Fetch user preferences from the database

        $access_token = $request->bearerToken(); // Get the access token from the request



        if ($access_token) {
            // Find the user based on the provided access token
            $user = User::where('access_token', $access_token)->first();

            if ($user) {
                
                //UserSource::
                //$user->sources()->attach($request['sources']);
                //$user->categories()->attach($request['categories']);
                
                $user->sources()->sync($request['sources']);
                $user->categories()->sync($request['categories']);

            }
        }


        // Return a success response

        

    }
}
