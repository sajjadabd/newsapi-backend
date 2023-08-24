<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    
    // Registration
    public function register(Request $request)
    {
        // Validation logic here
        // Create a new user and save to the database
        // Log in the user
        return redirect()->intended('/dashboard');
    }


}
