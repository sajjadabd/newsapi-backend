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

        $token = $user->createToken('access_token')->plainTextToken;


        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $token,
        ]);
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
            $token = $user->createToken('access_token')->plainTextToken;
            
            return response()->json([
                'user' => new UserResource($user),
                'access_token' => $token,
            ]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
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




    // login a user method
    public function login1(LoginRequest $request) {
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

}
