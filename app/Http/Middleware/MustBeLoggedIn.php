<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustBeLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $access_token = $request->bearerToken(); // Get the access token from the request

        if ($access_token) {
            // Find the user based on the provided access token
            $user = User::where('access_token', $access_token)->first();

            if ($user) {
                
                return $next($request);

            }
        }

        
        return response()->json([
            'message' => 'you must be logged in'
        ])
    }
}
