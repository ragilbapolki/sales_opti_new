<?php

namespace App\Http\Middleware;

use Closure;

class MobileMiddleware
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
 
        $token = $request->input('token');
        if (!($token) || $token != 'mobilesales77' ) {
            // dd($request->input('token'));
            return response()->json(['massage'=>'','status' => 404]);
            // abort(404);
        }
        return $next($request);
    }
}
