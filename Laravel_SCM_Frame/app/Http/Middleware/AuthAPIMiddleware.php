<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthAPIMiddleware
{
  /**
   * Handle an incoming request.
   * This handles request is authorized or not.
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if (!Auth::guard('api')->user()) {
      return response()->json(
        ['error' => 'Unauthorized!'],
        JsonResponse::HTTP_UNAUTHORIZED
      );
    }
    return $next($request);
  }
}
