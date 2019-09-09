<?php

namespace App\Http\Controllers\Api\Helper;

use Illuminate\Contracts\Validation\Validator;

class RespondHelper
{
  public function respondLoginSuccess($message = 'Created', $role = '', $token = '')
  {
    return response()->json([
      'code' => 201,
      'message' => $message,
      'role' => $role,
      'token' => $token,
      'user_id' => \JWTAuth::toUser($token)->id
    ], 201);
  }

  public function respondLoginFailed($message = 'Unauthorized', $return = '', $token = '')
  {
    return response()->json([
      'code' => 401,
      'errors' => array($message)
    ], 401);
  }

  public function respondCreated($message = 'Created', $return = '', $token = '')
  {
    return response()->json([
      'code' => 201,
      'message' => $message,
    ], 201);
  }

  public function respondSuccess($message = 'Success', $return = '', $token = '')
  {
    return response()->json([
      'code' => 200,
      'message' => $message,
    ], 200);
  }

  public function respondError($message = 'Unknown Error', $return = '', $token = '')
  {
    return response()->json([
      'code' => 701,
      'message' => $message,
    ], 500);
  }

  public function respondUserStatusFailed($message = 'Invalid user status', $return = '', $token = '')
  {
    return response()->json([
      'code' => 700,
      'message' => $message,
    ], 200);
  }

  static function respondValidationError(Validator $validator)
  {
    return json()->unprocessableError($validator->errors()->all());
  }
}
