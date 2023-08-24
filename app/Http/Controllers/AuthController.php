<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    
    // register a new user method
    public function register(RegisterRequest $request) {

        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
        ]);
    }

    // login a user method
    public function login(LoginRequest $request) {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Email or password is incorrect!'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'user' => new UserResource($user),
        ]);
    }

    // logout a user method
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();


        return response()->json([
            'message' => 'Logged out successfully!'
        ]);
    }

    // get the authenticated user method
    public function user(Request $request) {
        return new UserResource($request->user());
    }

}
