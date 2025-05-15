<?php

namespace App\Http\Middleware\Roles;

use Auth;
use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        } elseif( Auth::user()->role_id == 1){
            return $next($request);
        } else {
            return response('unauthorrized');
            // return redirect()->route('unauthorized');
        }
    }
}
