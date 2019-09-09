<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ClientProfile;
use App\Transformers\ClientProfileTransformer;

class ClientProfilesController extends Controller
{
    public function index()
    {
        return json()->withCollection(
            ClientProfile::all(),
            new ClientProfileTransformer
        );
    }

    public function store(Request $request)
    {
        // Assumes that validation is done by a Form Request
        return json()->created(
            $request->clientProfile()->create($request->all())
        );
    }

    public function show($id)
    {
        return json()->withItem(
            ClientProfile::findOrFail($id),
            new ClientProfileTransformer
        );
    }

    public function update(Request $request, $id)
    {
        $clientProfile = ClientProfile::findOrFail($id);

        return ($clientProfile->update($request->all()))
            ? json()->success('Updated')
            : json()->error('Failed to update');
    }

    public function destroy($id)
    {
        $clientProfile = ClientProfile::findOrFail($id);

        return ($clientProfile->delete())
            ? json()->success('Deleted')
            : json()->error('Failed to delete');
    }
}
