<?php

namespace App\Http\Controllers\Api;

use App\Mail\ContactUsMailable;
use Bican\Roles\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use App\User;
use Tymon\JWTAuth\JWTAuth;
use App\Models\Lawfirm;
use App\Models\Profile;

use Mail;
use function App\Http\Controllers\Api\Helper\respondSuccess;
use App\Http\Controllers\Api\Helper\RespondHelper;

use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;

class UsersController extends Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->respond_helper = new RespondHelper;
  }

  public function store(Request $request)
  {
    $rule = [
      'email' => 'required|max:255|email',
      'password' => 'required|min:6',
    ];

    $validator = \Validator::make($request->only('email', 'password'), $rule);
    if ($validator->fails()) {
      return RespondHelper::respondValidationError($validator);
    }
    $input = $request->all();
    $input['password'] = bcrypt($input['password']);

    $count = User::where(['email' => $input['email']])->get()->count();
    if ($count > 0) {
      return json()->notAcceptableError('Email address exist.');
    }

    $confirmation_code = str_random(30);

    $user = new User();
    $user->email = $input['email'];
    $user->password = $input['password'];
    $user->confirmation_code = $confirmation_code;
    $user->save();

    // Set user role
    $role = Role::where('slug', $input['role'])->get();
    $user->attachRole($role);

    // Set user profile
    $profile = new Profile($input['profile']);
    $profile->user_id = $user->id;
    $profile->avatar = "../../../../assets/common/img/avatar.png";
    $profile->save();

    // Send confirmation email
    try {
      $front_url = $request->input('front_url');
      $email = $user->email;
      $reset_link = $front_url . '/account/register/verify/' . $confirmation_code;
      $data = array(
        'email' => $email,
        'reset_link' => $reset_link,
      );

      Mail::send('emails.verify', $data, function ($message) use ($email) {
        $message->to($email, 'www.ezdocpro.com')
          ->subject('Verify your email address');
      });
    }
    catch(Exception $e) {
      $profile->forceDelete();
      $user->forceDelete();
    }

    return $this->respondCreated($user);
  }

  protected function respondCreated(User $user)
  {
    return response()->json([
      'code' => 200,
      'token' => \JWTAuth::fromUser($user),
      'user_id' => $user->id
    ], 200);
  }

  public function index(Request $request)
  {
    if (!$this->isSuperAdmin($request)) {
      return json()->notAcceptableError(Controller::$NOT_SUPER_ADMIN);
    }

    return User::all();
  }

  public function show(Request $request, $id)
  {
    if (!$this->isSuperAdmin($request)) {
      return json()->notAcceptableError(Controller::$NOT_SUPER_ADMIN);
    }

    return User::find($id);
  }

  public function contactUs(Request $request)
  {
    $rules = [
      'email' => 'required|email',
    ];

    $validator = \Validator::make($request->only('email'), $rules);
    if ($validator->fails()) {
      return $this->respondValidationError($validator);
    }

    $email = $request->input('email');
    $username = $request->input('username');
    $body = $request->input('message');
    $phone = $request->input('phone');

    $data = array(
      'email' => $email,
      'username' => $username,
      'phone' => $phone,
      'body' => $body
    );

    \Session::flash('email', $email);

    return
      Mail::send('emails.contactUs', $data, function ($message) {
        $message->from('hook30552@gmail.com', 'www.ezdocpro.com');
        $message->to(session('email'))->subject('Contact us');
      })
        ? $this->respond_helper->respondSuccess('Succeed in sending Email.')
        : $this->respond_helper->respondError('Failed to send.');
  }

  public function forgotPassword(Request $request)
  {
    $rules = [
      'email' => 'required|email',
    ];

    $validator = \Validator::make($request->only('email'), $rules);
    if ($validator->fails()) {
      return RespondHelper::respondValidationError($validator);
    }

    $email = $request->input('email');
    $front_url = $request->input('front_url');

    $user = User::where('email', $email)->first();

    if (isset($user)) {
      $trim = md5($user->password);

      $reset_link = $front_url . '/account/password/reset/' . base64_encode($email) . '_fi35_' . $trim;
      $data = array(
        'username' => $user->username,
        'email' => $email,
        'reset_link' => $reset_link
      );

      \Session::flash('email', $email);

      return
        Mail::send('emails.resetPassword', $data, function ($message) {
          $message->from('hook30552@gmail.com', 'www.ezdocpro.com');
          $message->to(session('email'))->subject('Reset password');
        })
          ? $this->respond_helper->respondSuccess('Succeed in sending Email.')
          : $this->respond_helper->respondError('Failed to send.');
    } else {
      return json()->badRequestError('The email address is not exist in database.');
    }
  }

  public function confirmLawfirm(Request $request)
  {
    $inputs = $request->all();
    $lawfirm = Lawfirm::find($inputs['id']);
    if (isset($lawfirm->password)) {
      if (base64_encode($inputs['password']) == $lawfirm->password) {
        return json()->success('Lawfirm confirm succeed.');
      } else {
        return json()->notAcceptableError('The lawfirm password is incorrect.');
      }
    }

    return json()->badRequestError('The lawfirm is not exist.');
  }

  public function getMe(Request $request)
  {
    $user = \JWTAuth::toUser($request->input('token'));
    $user->lawfirm = $user->profile->lawfirm;

    return $user;
  }

  public function verifyRegister(Request $request)
  {
    $data = $request->all();
    $user = User::where('confirmation_code', $data['confirmation_code'])->first();
    if($user) {
      $token = \JWTAuth::attempt(['email' => $user->email, 'password' => $data['password']]);
      if($token === false) {
        return json()->badRequestError('Password is incorrect!');
      }

      $user->status = 'approved';
      $user->save();

      return json()->success('You have been approved. Please log in now!');
    }

    return json()->badRequestError('Your confirmation code is not exist!');
  }
}
