<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Transformers\UserTransformer;

class NewUsersController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getNewUsers(Request $request)
  {
    if (!$this->isAdmin($request)) {
      return json()->notAcceptableError(Controller::$NOT_ADMIN);
    }

    $user = \JWTAuth::toUser($request->input('token'));
    $profile = $user->profile;
    $lawfirm_id = $profile->lawfirm_id;
    $users = User::all();
    $new_users = [];
    foreach ($users as $user) {
      if ($user->profile->lawfirm_id == $lawfirm_id) {
        array_push($new_users, $user);
      }
    }

    return $new_users;
  }

  public function approveUser(Request $request)
  {
    if (!$this->isAdmin($request)) {
      return json()->notAcceptableError(Controller::$NOT_ADMIN);
    }

    $ids = $request->ids;
    foreach ($ids as $id) {
      $user = User::find($id);
      $user->status = 'approved';
      $user->save();
    }

    return json()->success('The users have been approved.');
  }


  public function dismissUser(Request $request)
  {
    if (!$this->isAdmin($request)) {
      return json()->notAcceptableError(Controller::$NOT_ADMIN);
    }

    $ids = $request->ids;
    foreach ($ids as $id) {
      $user = User::find($id);
      if($user->is('superadmin')) {
        return json()->notAcceptableError('You can\'t dismiss a super admin.');
      }
      $user->status = 'dismiss';
      $user->save();
    }

    return json()->success('The users have been dismissed.');
  }
}
