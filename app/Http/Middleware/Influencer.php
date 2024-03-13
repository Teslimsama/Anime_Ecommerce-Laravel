<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Influencer
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
        if ($request->user()->role == 'influencer') {
            return $next($request);
        } else {
            request()->session()->flash('error', 'You do not have any permission to access this page');
            return redirect()->route($request->user()->role);
        }
        // return $next($request);
    }
}
