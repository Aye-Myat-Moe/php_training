<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AdminAPIMiddleware
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
    if (!Auth::guard('api')->user() || Auth::guard('api')->user()->type != '0') {
      return response()->json(
        ['error' => 'Unauthorized!'],
        JsonResponse::HTTP_UNAUTHORIZED
      );
    }
    return $next($request);
  }
}
