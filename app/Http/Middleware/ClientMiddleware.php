<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next):Response
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->role_id == 1) {
            return $next($request);

        }
            else {
                return abort(403);
            }


    }
        else {
        return abort(403);
        }
    }
}
