<?php

namespace App\Http\Controllers\Api\V1;

use function foo\func;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Doc;
use App\Transformers\DocTransformer;
use App\Models\Client;
use App\Models\Lawfirm;
use App\User;
use App\Models\Profile;

class DocsController extends Controller
{
  public function index()
  {
    $data = Doc::all();
    
    return json()->withCollection(
      $data,
      new DocTransformer
    );
  }

  public function store(Request $request)
  {
    $inputs = $request->all();
    $user = $this->current_user($request);
    if($user == null) {
      return json()->error("You have no permission.");
    }

    $data = $inputs['data'];

    $doc = Doc::where(['client_id' => $inputs['client_id'], 'form_id' => $inputs['form_id']])->first();
    if ($doc) {
      return $this->update($request, $doc->id);
    }

    $array = [];
    foreach ($data as $row) {
      if ($row['foreign_key'] == '') {
        $array[$row['key']] = $row['value'];
      }
    }
    $doc = new Doc();
    $doc->client_id = $inputs['client_id'];
    $doc->form_id = $inputs['form_id'];
    $doc->user_id = $user->id;
    $doc->data = json_encode($array);
    $doc->save();

    return json()->created('The doc has been created.');
  }

  public function show($id)
  {
    function getCollection($array, $table, $data)
    {
      if ($array != null) $array = $array->toArray(); else return $data;
      foreach ($array as $key => $row) {
        $data["$table.$key"] = $row;
      }
      return $data;
    }

    function getCollection1($array, $table, $type, $data)
    {
      if ($array != null) $array = $array->toArray(); else return $data;
      foreach ($array as $key => $row) {
        foreach ($row as $key1 => $row1) {
          $data["$table.$key1, $type=$row[$type]"] = $row1;
        }
      }
      return $data;
    }

    function getCollection2($array, $table, $data)
    {
      if ($array != null) $array = $array->toArray(); else return $data;
      $i = 0;
      foreach ($array as $key => $row) {
        $i++;
        foreach ($row as $key1 => $row1) {
          $data["$table.$key1, []=$i"] = $row1;
        }
      }
      return $data;
    }

    function getCollection3($array, $data)
    {
      if (!isset($array)) return $data;
      foreach ($array as $key => $row) {
        $data["$key"] = $row;
      }
      return $data;
    }

    $doc = Doc::withTrashed()->findOrFail($id);
    $data = [
      'doc' => $doc
    ];

    $client = Client::withTrashed()->findOrFail($doc->client_id);
    $client_profile = $client->clientProfile;
    $relationships = $client->clientRelationship;
    $addresses = $client->backgroundAddresses;
    $schools = $client->backgroundSchools;
    $employs = $client->backgroundEmploys;
    $families = $client->backgroundFamilies;
    $application = $client->clientApplication;
    $signature = $client->clientSignature;
    $prepares = $client->clientPreparer;
    $doc_data = json_decode($doc->data);

    $lawfirm = Lawfirm::withTrashed()->findOrFail($client->lawfirm_id);
    $user = User::withTrashed()->findOrFail($doc->user_id);
    $profile = Profile::withTrashed()->findOrFail($user->id);

    $data = getCollection($client, 'clients', $data);
    $data = getCollection($client_profile, 'client_profiles', $data);
    $data = getCollection1($relationships, 'client_relationships', 'relation_type', $data);
    $data = getCollection1($addresses, 'background_addresses', 'address_type', $data);
    $data = getCollection2($schools, 'background_schools', $data);
    $data = getCollection2($employs, 'background_employes', $data);
    $data = getCollection1($families, 'background_families', 'family_type', $data);
    $data = getCollection($application, 'client_applications', $data);
    $data = getCollection($signature, 'client_signatures', $data);
    $data = getCollection($prepares, 'client_prepareres', $data);
    $data = getCollection3($doc_data, $data);
    $data = getCollection($lawfirm, 'lawfirms', $data);
    $data = getCollection($profile, 'profiles', $data);
    $data = getCollection($user, 'users', $data);

    return $data;
  }

  public function update(Request $request, $id)
  {
    $inputs = $request->all();
    $data = $inputs['data'];
    $array = [];
    foreach ($data as $row) {
      if ($row['foreign_key'] == '') {
        $array[$row['key']] = $row['value'];
      }
    }
    $doc = Doc::findOrFail($id);
    $doc->data = json_encode($array);
    $doc->save();

    return json()->success('The doc has been updated.');
  }

  public function destroy($id)
  {
    $doc = Doc::findOrFail($id);

    return ($doc->delete())
      ? json()->success('The doc has been deleted.')
      : json()->error('Failed to delete');
  }

  public function selectDocs(Request $request)
  {
    $client_id = $request->input('client_id');
    $form_ids = $request->input('ids');
    $current_user = $this->current_user($request);
    foreach ($form_ids as $form_id) {
      $doc = Doc::onlyTrashed()
        ->where('client_id', $client_id)
        ->where('form_id', $form_id)
        ->first();
      if ($doc != null) {
        $doc->restore();
        $doc->data = null;
        $doc->save();
      } else {
        $doc = new Doc;
        $doc->client_id = $client_id;
        $doc->form_id = $form_id;
        $doc->user_id = $current_user->id;
        $doc->save();
      }
    }

    return json()->success('The docs have been selected');
  }

  public function deleteDocs(Request $request)
  {
    $client_id = $request->input('client_id');
    $form_ids = $request->input('ids');
    foreach ($form_ids as $form_id) {
      $doc = Doc::where('client_id', $client_id)
        ->where('form_id', $form_id)
        ->first();
      $doc->data = null;
      $doc->save();
      $doc->delete();
    }

    return json()->success('The docs have been deleted');
  }

  public function getDoc(Request $request)
  {
    $client_id = $request->input('client_id');
    $form_id = $request->input('form_id');
    $doc = Doc::withTrashed()
      ->where('client_id', $client_id)
      ->where('form_id', $form_id)
      ->first();

    return $this->show($doc->id);
  }

  public function approveDismiss(Request $request)
  {
    $doc_id = $request->input('doc_id');
    $approve = $request->input('approve') == 'true' ? 1 : 0;
    $doc = Doc::find($doc_id);
    $doc->approved = $approve;
    $doc->save();

    return json()->success($doc->approved);
  }
}
