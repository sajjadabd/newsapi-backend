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
        $request->validate([
            'access_token' => ['required'],
        ]);

        $access_token = $request->input('access_token');

        if ($access_token) {
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
