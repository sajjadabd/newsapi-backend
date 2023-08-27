<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    private function generateAccessToken()
    {
        // Generate a unique access token using any logic you prefer
        return bin2hex(random_bytes(32)); // Example: Generating a random hex token
    }


    private function generateAndSaveAccessToken(User $user)
    {
        // Generate a unique access token using any logic you prefer
        $access_token = $this->generateAccessToken(); // Example: Generating a random hex token
        $user->update(['access_token' => $access_token]);
        
        return $access_token;
    }

    
    // register a new user method
    public function register(RegisterRequest $request) {

        $validatedData = $request->validate([
            'username' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::create(array_merge(
            $validatedData,
            ['password' => bcrypt($request->password)]
        ));

        //$token = $user->createToken('access_token')->plainTextToken; // for sanctum

        $access_token = $this->generateAndSaveAccessToken($user);

        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $access_token,
        ]);
    }





    public function validateToken(Request $request)
    {
        $user = $request->user;

        if ($user) {
            return response()->json([
                'user' => new UserResource($user),
                'valid' => true
            ]);
        }

        return response()->json(['valid' => false]);
    }

    



    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //$credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            //$token = $user->createToken('access_token')->plainTextToken;
            
            $access_token = $this->generateAndSaveAccessToken($user);

            return response()->json([
                'user' => new UserResource($user),
                'access_token' => $access_token,
            ]);

        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }



    // logout a user method
    public function logout(Request $request) {

        $user = $request->user;

        if ($user) {
            // Delete the access token from the user's record
            $user->update(['access_token' => null]);
            return response()->json([
                'success' => 'true',
                'message' => 'Logged out successfully'
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // get the authenticated user method
    public function user(Request $request) {
        return new UserResource($request->user());
    }



}
