<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\InviteTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Invite;
use Mail;

class InvitesController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $data = Invite::all();
    
    return json()->withCollection(
      $data,
      new InviteTransformer
    );
  }

  public function store(Request $request)
  {
    $invite = new Invite;
    $invite->lawfirm_id = $request->input('lawfirm_id');
    $invite->email = $request->input('email');
    $invite->save();

    $data = [
      'email' => $invite->email,
      'lawfirm' => $invite->lawfirm->name
    ];

    \Session::flash('email', $invite->email);

    return
      Mail::send('emails.invite', $data, function ($message) {
        $message->from('hook30552@gmail.com', 'www.ezdocpro.com');
        $message->to(session('email'))->subject('Invited by lawfirm.');
      })
        ? json()->success('Succeed in sending Email.')
        : json()->badRequestError('Failed to invite.');
  }

  public function show($id)
  {
    return json()->withItem(
      Invite::findOrFail($id),
      new InviteTransformer
    );
  }

  public function update(LawfirmsRequest $request, $id)
  {
    //
  }

  public function destroy($id)
  {
    return (Invite::destroy($id))
      ? json()->success('The invite has been deleted.')
      : json()->badRequestError('Invite deletion has been failed.');
  }

  public function getInvites(Request $request)
  {
    $lawfirm_id = $request->lawfirm_id;
    $invites = Invite::where(['lawfirm_id' => $lawfirm_id])->get();

    return $invites;
  }

  public function getInvitesByEmail(Request $request)
  {
    $invites = Invite::where(['email' => $request->email])->get();
    return $invites;
  }

  public function getAllInvites(Request $request)
  {
    $invites = Invite::all();
    return $invites;
  }
}
