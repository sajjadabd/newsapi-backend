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

        $user = $request->user;
        
        $sources = Source::all();
        $categories = Category::all();
        
        return response()->json([
            'success' => true,
            'sources' => $sources,
            'categories' => $categories,
            'user_sources' => $user->sources,
            'user_categories' => $user->categories,
        ]);



    }

    // Update user's preferences
    public function updatePreferences(Request $request)
    {
        $validated = $request->validate([
            'sources' => 'required|array',
            'categories' => 'required|array',
        ]);

        $user = $request->user;
        
        $user->sources()->sync($validated['sources']);
        $user->categories()->sync($validated['categories']);

        return response()->json([
            'success' => true,
            'message' => 'Preferences updated successfully.',
        ]);

    }
}
