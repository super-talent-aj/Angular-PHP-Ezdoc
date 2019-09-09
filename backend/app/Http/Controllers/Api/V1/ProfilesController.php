<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Lawfirm;
use App\Transformers\ProfileTransformer;
use App\User;
use URL;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Validation\Validator;

class ProfilesController extends Controller
{
  public function index()
  {
    $data = Profile::all();

    return json()->withCollection(
      $data,
      new ProfileTransformer
    );
  }

  public function show($id)
  {
    return json()->withItem(
      Profile::findOrFail($id),
      new ProfileTransformer
    );
  }

  public function update(Request $request, $id)
  {
    $input = $request->all();
    unset($input['email']);
    $profile = Profile::findOrFail($id);

    return ($profile->update($input))
      ? json()->success('The profile has been updated.')
      : json()->error('Failed to update');
  }

  public function destroy($id)
  {
    $profile = Profile::findOrFail($id);

    return ($profile->delete())
      ? json()->success('The profile has been deleted.')
      : json()->error('Failed to delete');
  }

  public function getProfile(Request $request, $user_id)
  {
    return json()->withItem(
      Profile::where('user_id', $user_id)->first(),
      new ProfileTransformer
    );
  }
}
