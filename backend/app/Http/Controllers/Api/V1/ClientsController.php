<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\BackgroundAddress;
use App\Models\BackgroundEmploy;
use App\Models\BackgroundFamily;
use App\Models\BackgroundSchool;
use App\Models\ClientApplication;
use App\Models\ClientPreparer;
use App\Models\ClientProfile;
use App\Models\ClientRelationship;
use App\Models\ClientSignature;
use App\Models\Form;
use App\Models\Notification;
use Illuminate\Http\Request;

use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Transformers\ClientTransformer;
use PhpParser\Node\Expr\Cast\Object_;

class ClientsController extends Controller
{
  public function index(Request $request)
  {
    $size = $request->input('size');
    $size = $size ? $size : 10;

    return json()->withPagination(
      Client::latest()->paginate($size),
      new ClientTransformer
    );
  }

  public function getUserClients($user_id)
  {
    return Client::where(['user_id' => $user_id])->get();
  }

  public function buildClient($inputs, $type = 'create', $client_id = 0)
  {
    if ($type == 'create') {
      $client = new Client();
      $profile = new ClientProfile();
      $relationships = [];
      $addresses = [];
      $schools = [];
      $employs = [];
      $families = [];
      $application = new ClientApplication();
      $signature = new ClientSignature();
      $preparer = new ClientPreparer();
    } else {
      $client = Client::find($client_id);
      $profile = $client->clientProfile;
      $relationships = $client->clientRelationship;
      $addresses = $client->backgroundAddresses;
      $schools = $client->backgroundSchools;
      $employs = $client->backgroundEmploys;
      $families = $client->backgroundFamilies;
      $application = $client->clientApplication;
      $signature = $client->clientSignature;
      $preparer = $client->clientPreparer;
    }


    foreach ($inputs as $input) {
      $value = $input['value'];
      $type = $input['type'];
      $foreign_key = $input['foreign_key'];
      $foreign_key = str_replace(' ', '', $foreign_key);
      if ($foreign_key != '') {
        $array1 = explode(',', $foreign_key);
        $array2 = explode('.', $array1[0]);
        $table = $array2[0];
        $field = $array2[1];

        $obj = null;
        switch ($table) {
          case 'clients':
            $obj = $client;
            break;
          case 'client_profiles':
            $obj = $profile;
            break;
          case 'client_applications':
            $obj = $application;
            break;
          case 'client_signatures':
            $obj = $signature;
            break;
          case 'client_prepareres':
            $obj = $preparer;
            break;
          default:
            $obj = null;
            break;
        }

        if (isset($array1[1])) {
          $array3 = explode('=', $array1[1]);
          $sub_key = $array3[0];
          $sub_value = $array3[1];

          switch ($table) {
            case 'client_relationships':
              if (!isset($relationships[$sub_value])) {
                if ($type == 'create') {
                  $relationships[$sub_value] = new ClientRelationship();
                } else {
                  $relationships[$sub_value] = ClientRelationship::where(['relation_type' => $sub_value, 'client_id' => $client_id])->first();
                  if (is_null($relationships[$sub_value])) {
                    $relationships[$sub_value] = new ClientRelationship();
                    $relationships[$sub_value]->client_id = $client_id;
                    $relationships[$sub_value]->relation_type = $sub_value;
                  }
                }
                $relationships[$sub_value]->$sub_key = $sub_value;
              }
              $obj = $relationships[$sub_value];
              break;
            case 'background_addresses':
              if (!isset($addresses[$sub_value])) {
                if ($type == 'create') {
                  $addresses[$sub_value] = new BackgroundAddress();
                } else {
                  $addresses[$sub_value] = BackgroundAddress::where(['address_type' => $sub_value, 'client_id' => $client_id])->first();
                  if (is_null($addresses[$sub_value])) {
                    $addresses[$sub_value] = new BackgroundAddress();
                    $addresses[$sub_value]->client_id = $client_id;
                    $addresses[$sub_value]->address_type = $sub_value;
                  }
                }
                $addresses[$sub_value]->$sub_key = $sub_value;
              }
              $obj = $addresses[$sub_value];
              break;
            case 'background_schools':
              if (!isset($schools[$sub_value])) {
                if ($type == 'create') {
                  $schools[$sub_value] = new BackgroundSchool();
                } else {
                  $schools[$sub_value] = $schools[$sub_value - 1];
                  if (is_null($schools[$sub_value])) {
                    $schools[$sub_value] = new BackgroundSchool();
                    $schools[$sub_value]->client_id = $client_id;
                  }
                }
              }
              $obj = $schools[$sub_value];
              break;
            case 'background_employes':
              if (!isset($employs[$sub_value])) {
                if ($type == 'create') {
                  $employs[$sub_value] = new BackgroundEmploy();
                } else {
                  $employs[$sub_value] = $employs[$sub_value - 1];
                  if (is_null($schools[$sub_value])) {
                    $employs[$sub_value] = new BackgroundEmploy();
                    $employs[$sub_value]->client_id = $client_id;
                  }
                }
              }
              $obj = $employs[$sub_value];
              break;
            case 'background_families':
              if (!isset($families[$sub_value])) {
                if ($type == 'create') {
                  $families[$sub_value] = new BackgroundFamily();
                } else {
                  $families[$sub_value] = BackgroundFamily::where(['family_type' => $sub_value, 'client_id' => $client_id])->first();
                  if (is_null($families[$sub_value])) {
                    $families[$sub_value] = new BackgroundFamily();
                    $families[$sub_value]->client_id = $client_id;
                    $families[$sub_value]->family_type = $sub_value;
                  }
                }
              }
              $obj = $families[$sub_value];
              break;
          }
        }

        if ($obj != null) {
          if ($type != 'checkbox') {
            $obj->$field = $value;
          } else if ($type == 'checkbox') {
            foreach ($value as $row) {
              $advanced_field = $field . $row;
              $obj->$advanced_field = 1;
            }
          }
        }
      }
    }

    $data = [
      'client' => $client,
      'profile' => $profile,
      'relationships' => $relationships,
      'addresses' => $addresses,
      'schools' => $schools,
      'employs' => $employs,
      'families' => $families,
      'application' => $application,
      'signature' => $signature,
      'preparer' => $preparer,
    ];

    return $data;
  }

  public function store(Request $request)
  {
    $inputs = $request->all();
    $data = $this->buildClient($inputs['data']);
    
    
    $user = \JWTAuth::toUser($inputs['token']);
    $data['client']->user_id = $user->id;
    $data['client']->lawfirm_id = $user->profile->lawfirm->id;
    $data['client']->save();
    $client_id = $data['client']->id;

    $data['profile']->client_id = $client_id;
    $data['profile']->save();
    foreach ($data['relationships'] as $row) {
      $row->client_id = $client_id;
      $row->save();
    }
    foreach ($data['addresses'] as $row) {
      $row->client_id = $client_id;
      $row->save();
    }
    foreach ($data['schools'] as $row) {
      $row->client_id = $client_id;
      $row->save();
    }
    foreach ($data['employs'] as $row) {
      $row->client_id = $client_id;
      $row->save();
    }
    foreach ($data['families'] as $row) {
      $row->client_id = $client_id;
      $row->save();
    }
    $data['application']->client_id = $client_id;
    $data['application']->save();
    $data['signature']->client_id = $client_id;
    $data['signature']->save();
    $data['preparer']->client_id = $client_id;
    $data['preparer']->save();

    return [
      'message' => 'The client has been created successfully.',
      'client_id' => $client_id,
    ];
  }

  public function show($id)
  {
    $data = Client::withTrashed()->findOrFail($id);

    return json()->withItem(
      $data,
      new ClientTransformer
    );
  }

  public function update(Request $request, $id)
  {
    $inputs = $request->all();
    $data = $this->buildClient($inputs['data'], 'update', $id);

    $client = $data['client'];
    $user = \JWTAuth::toUser($request->input('token'));
    $lawfirm = $user->profile->lawfirm;
    if ($lawfirm->id != $client->lawfirm_id) {
      return json()->notAcceptableError('You can\'t update other lawfirm\'s client.');
    }

    if (!is_null($data['client'])) $data['client']->save();
    if (!is_null($data['profile'])) $data['profile']->save();
    foreach ($data['relationships'] as $row) {
      if (!is_null($row)) $row->save();
    }
    foreach ($data['addresses'] as $row) {
      if (!is_null($row)) $row->save();
    }
    foreach ($data['schools'] as $row) {
      if (!is_null($row)) $row->save();
    }
    foreach ($data['employs'] as $row) {
      if (!is_null($row)) $row->save();
    }
    foreach ($data['families'] as $row) {
      if (!is_null($row)) $row->save();
    }
    if (!is_null($data['application'])) $data['application']->save();
    if (!is_null($data['signature'])) $data['signature']->save();
    if (!is_null($data['preparer'])) $data['preparer']->save();

    return json()->success('The client has been updated.');
  }

  public function destroy(Request $request, $id)
  {
    $client = Client::findOrFail($id);

    $user = \JWTAuth::toUser($request->input('token'));
    $lawfirm = $user->profile->lawfirm;
    if ($lawfirm->id != $client->lawfirm_id) {
      return json()->notAcceptableError('You can\'t delete other lawfirm\'s client.');
    }

    // Send notification of client deletion to admin
    $admins = LawfirmsController::getAdmins($lawfirm);
    foreach ($admins as $admin) {
      $type = 'client_deletion';
      $message = "Client #$client->id($client->last_name, $client->first_name) has been deleted.\nYou can reactivate deleted clients.";
      $notification = new Notification;
      $notification->user_id = $admin->id;
      $notification->type = $type;
      $notification->message = $message;
      $notification->save();
    }

    return ($client->delete())
      ? json()->success('The client has been deleted.')
      : json()->error('Failed to delete the client.');
  }

  public function getDeletedClients(Request $request)
  {
    $user = \JWTAuth::toUser($request->input('token'));
    $lawfirm_id = $user->profile->lawfirm->id;

    return Client::where(['lawfirm_id' => $lawfirm_id])->onlyTrashed()->get();
  }

  public function reactivateClients(Request $request)
  {
    if (!$this->isAdmin($request)) {
      return json()->notAcceptableError(Controller::$NOT_ADMIN);
    }

    $ids = $request->ids;
    foreach ($ids as $id) {
      $client = Client::onlyTrashed()->find($id);
      $client->restore();
    }

    return json()->success('The clients have been restored.');
  }

  public function getForms($id)
  {
    $client = Client::findOrFail($id);
    $docs = $client->docs;
    foreach ($docs as $doc) {
      $form = Form::findOrFail($doc->form_id);
      $doc->form_type = $form->type;
    }
    return $docs;
  }

  public function deleteClients(Request $request)
  {
    $ids = $request->input('ids');
    foreach ($ids as $id) {
      $this->destroy($request, $id);
    }
    return json()->success('Succeed to delete clients.');
  }

  public function getLawfirmClients(Request $request)
  {
    $user = \JWTAuth::toUser($request->input('token'));
    $clients = $user->profile->lawfirm->clients;

    return $clients;
  }
}
