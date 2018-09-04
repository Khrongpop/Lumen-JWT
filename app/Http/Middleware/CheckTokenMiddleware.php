<?php

namespace App\Http\Middleware;

use Closure;

class CheckTokenMiddleware
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
      // echo $request->assToken;
      $token = $request->get('assToken');

      if($token && $token== "test") {
        return $next($request);
      } else {
          return response()->json([
            'error' => 'Token not provided.'
        ], 401);
      }
    }
}
