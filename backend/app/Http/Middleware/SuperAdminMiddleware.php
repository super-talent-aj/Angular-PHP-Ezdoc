<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class SuperAdminMiddleware extends BaseMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if (!$token = $this->auth->setRequest($request)->getToken()) {
      throw new JWTException('token_not_provided', 400);
    }
    $user = \JWTAuth::toUser($token);
    if ($user->is('superadmin')) {
      return $next($request);
    }

    return json()->notAcceptableError('You have to log in as a super admin to access this process.');
  }
}
