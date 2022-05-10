<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if(!$user){
            return response()->json(['error' => 'Unauthorized action.'], 401);
        }

        $role_id = $user->role_id;

        if($role_id == 1){
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized user'], 401);

    }
}
