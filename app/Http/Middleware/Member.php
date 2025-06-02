<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Member
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
 
        if (Auth::check() && Auth::user()->role->name === 'member') {
            return $next($request);
        }

        // Jika tidak, redirect ke halaman yang sesuai (misalnya halaman login atau dashboard)
        return redirect()->route('login');
    }
    
}
