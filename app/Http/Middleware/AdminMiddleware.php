<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // If the user is not an admin
        if(Auth::user() && auth()->user()->role !== 'admin'){
            // Display 403 forbidden code with error message
            abort(403, 'Not authorized.');
        }
        return $next($request);
    }
}
