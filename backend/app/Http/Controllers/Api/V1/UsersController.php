<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Transformers\UserTransformer;

class UsersController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index(Request $request)
  {
    if (!$this->isSuperAdmin($request)) {
      return json()->notAcceptableError(Controller::$NOT_SUPER_ADMIN);
    }

    $data = User::all();

    return json()->withCollection(
      $data,
      new UserTransformer
    );
  }

  public function store(Request $request)
  {
    // TODO: Assumes that validation is done by a User Request
    return json()->created(
      $request->user()->create($request->all())
    );
  }

  public function show($id, Request $request)
  {
    if (!$this->isSuperAdmin($request)) {
      return json()->notAcceptableError(Controller::$NOT_SUPER_ADMIN);
    }

    $user = User::findOrFail($id);
    return json()->withItem(
      $user,
      new UserTransformer
    );
  }

  public function update(Request $request, $id)
  {
    if (!$this->isSuperAdmin($request) && !$this->isMe($request, $id)) {
      return json()->notAcceptableError();
    }

    $user = User::findOrFail($id);
    return ($user->update($request->all()))
      ? json()->success('The user has been updated.')
      : json()->error('Failed to update');
  }

  public function destroy(Request $request, $id)
  {
    if (!$this->isAdmin($request)) {
      return json()->notAcceptableError(Controller::$NOT_SUPER_ADMIN);
    }

    $user = User::findOrFail($id);
    $user->profile->delete();

    return ($user->delete())
      ? json()->success('The user has been deleted.')
      : json()->badRequestError('Failed to delete');
  }

  public function changePassword(Request $request, $id)
  {
    if (!$this->isMe($request, $id)) {
      return json()->notAcceptableError('You can\'t change other user\'s password.');
    }

    $user = User::findOrFail($id);
    $old_password = $request->input('old_password');
    if (password_verify($old_password, $user->password)) {
      $new_password = $request->input('new_password');
      $user->password = bcrypt($new_password);
      return ($user->save())
        ? json()->success('The user password has been changed.')
        : json()->badRequestError('Failed to change the user password.');
    } else {
      return json()->badRequestError("Current Password is not correct.");
    }
  }

  public function deleteUsers(Request $request)
  {
    if (!$this->isSuperAdmin($request)) {
      return json()->notAcceptableError();
    }

    $ids = $request->ids;
    $token = $request->input('token');
    $user_id = \JWTAuth::toUser($token)->id;
    foreach ($ids as $id) {
      if ($user_id == $id) {
        return json()->notAcceptableError('It is not allowed to delete yourself.');
      }
      $this->destroy($request, $id);
    }

    return json()->success('The users have been deleted.');
  }
}
