<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class AdminMiddleware extends BaseMiddleware
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
    if ($user->is('superadmin') || $user->is('admin')) {
      return $next($request);
    }

    return json()->notAcceptableError('You have to log in as an admin to access this process.');
  }
}
