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
                ]);
            }
        }

        // Return preferences in the response



    }

    // Update user's preferences
    public function updatePreferences(Request $request)
    {
        // Validate request data
        // Update user preferences in the database
        // Return a success response
    }
}
