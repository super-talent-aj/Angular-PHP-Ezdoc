<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Contracts\Validation\Validator;
use App\User;
use App\Http\Controllers\Api\Helper\RespondHelper;
use App\Http\Requests\SessionsRequest;

class SessionsController extends Controller
{
  public function __construct()
  {
    $this->respond_helper = new RespondHelper;
  }

  public function store(SessionsRequest $request)
  {
    $token = \JWTAuth::attempt($request->only('email', 'password'));
    if (!$token) {
      return $this->respond_helper->respondLoginFailed('The credentials are invalid.');
    };

    $user_id = \JWTAuth::toUser($token)->id;
    $user = User::findOrFail($user_id);
    $role = $user->getRoles() ? $user->getRoles()[0]->slug : null;
    if ($user->status != 'approved') {
      return json()->notAcceptableError('Please get permission from your administrator.');
    }

    return $this->respond_helper->respondLoginSuccess('Login is successful.', $role, $token);
  }

  public function getTokenStatus(Request $request)
  {
    $token = $request->input('token');

    return \JWTAuth::toUser($token)
      ? json()->success('Token is existing.')
      : json()->error('Token is expired.');
  }
}
