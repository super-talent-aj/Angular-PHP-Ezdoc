<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Models\Profile;
use App\Models\Client;
use Auth;
use Mail;
use PDF;
use Illuminate\Support\Facades\Session;
use URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AuthController extends Controller
{
  public function resetPassword(Request $request)
  {
    $rules = [
      'email' => 'required|max:255',
    ];
    $validator = \Validator::make($request->only('email'), $rules);
    if ($validator->fails()) {
      return RespondHelper::respondValidationError($validator);
    }

    $email = $request->input('email');
    $user = User::where('email', $email)->first();
    if (!isset($user)) {
      return json()->notAcceptableError('Email is not exist.');
    }
    $md5_password = $request->input('md_password');
    if (md5($user->password) == $md5_password) {
      $password = $request->input('password');
      $user->password = bcrypt($password);
      $user->save();
      return json()->success('Password reset succeed.');
    }

    return json()->badRequestError('Password reset failed.');
  }

  public function checkCaptcha(Request $request) {
    $value = $request->input('captcha_value');
    $key = $request->input('captcha_key');
    $rules = ['captcha' => 'required|captcha'];
    $validator = \Validator::make(Input::all(), $rules);

    if (!captcha_api_check($value, $key)) {
      return $this->getCaptcha();
    }

    return json()->success("You are not a robot.");
  }

  public function getCaptcha() {
    $captcha = app('captcha')->create('default', true);
    return $captcha;
  }
}


