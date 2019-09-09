<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
  static $NOT_SUPER_ADMIN = 'You must have a super admin role to access this process.';
  static $NOT_ADMIN = 'You must have an admin role to access this process.';

  use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

  public function __construct()
  {
  }

  public function current_user(Request $request)
  {
    $user = \JWTAuth::toUser($request->input('token'));
    return $user;
  }

  public function isSuperAdmin(Request $request)
  {
    $user = $this->current_user($request);
    return $user->is('superadmin');
  }

  public function isAdmin(Request $request)
  {
    $user = $this->current_user($request);
    return $user->is('superadmin') || $user->is('admin');
  }

  public function isMe(Request $request, $id)
  {
    $user = $this->current_user($request);
    if (is_null($user) || !isset($user->id)) {
      return false;
    }
    return $user->id == $id;
  }
}